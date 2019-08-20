<?php

namespace App\Http\Controllers\course;

use App\model\CurrClassModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CurrChapterModel;
use DB;
class CourseController extends Controller
{
    /**
     * [课程审核视图]
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function audit(){
        #查询课程表中 添加的待审核的课程
        $courseInfo=DB::table('curr')->where(['curr_status'=>2])->get();
        return view('course.audit',compact('courseInfo'));
    }
    #审核通过
    public function audit_pass(Request $request){
        #接受课程的id
        $curr_id=$request->curr_id;
        if(empty($curr_id)){
            return ['code'=>5,'msg'=>'请选择要审核的课程'];
        }else{
            $update=DB::table('curr')->where(['curr_id'=>$curr_id])->update(['curr_status'=>1]);
            if($update){
                return ['code'=>1,'msg'=>'审核通过成功'];
            }else{
                return ['code'=>5,'msg'=>'审核通过失败'];
            }
        }
    }
    #审核不通过
    public function audit_no(Request $request){
        $data=$request->all();
        if($data['curr_id'] == ''){
            return ['code'=>5,'msg'=>'请选择要审核的课程'];
        }else if($data['text'] == ''){
            return ['code'=>5,'msg'=>'请输入不通过审核的原因'];
        }else{
            $update=DB::table('curr')->where(['curr_id'=>$data['curr_id']])->update(['curr_status'=>3,'update_text'=>$data['text']]);
            if($update){
                return ['code'=>1,'msg'=>'不通过审核成功'];
            }else{
                return ['code'=>5,'msg'=>'不通过审核失败'];
            }
        }
    }

    /**
     * [课程审核未通过列表]
     */
    public function audit_list_no(){
        #查询课程表中 未通过审核的课程
        $courseInfo=DB::table('curr')->where(['curr_status'=>3])->get();
        return view('course.audit_list_no',compact('courseInfo'));
    }

    /**
     * [视频审核视图]
     */
    public function video_audit(){
        #接收课程id
        $class_id=request()->get('class_id');
        if(empty($class_id)){
            return redirect('/curr/verifyList');
        }
        #查询课时信息
        $chapterInfo=CurrClassModel::where('class_id',$class_id)->first();
        return view('course.video_audit',['classInfo'=>$chapterInfo]);
    }
    #查询 章节信息
    public function curriculum(Request $request){
        #接受课程id
        $curr_id=$request->curr_id;
        #根据课程id 查询章节表
        $curr_chapter=DB::table('curr_chapter')->where('curr_id',$curr_id)->orderBy('chapter_num','asc')->get();
        //查询到直接返回
        if($curr_chapter){
            return $curr_chapter;
        }else{
            return 2;
        }
    }
    #查询 课时信息
    public function class_hour(Request $request){
        #获取章节id
        $chapter_id=$request->chapter_id;
        #根据章节id 查询课时表的 数据
        $class_hour=DB::table('curr_class_hour')->where(['chapter_id'=>$chapter_id,'video_status'=>3])->orderBy('class_hour_num','asc')->get();
        if($class_hour){
            return $class_hour;
        }else{
            return 2;
        }
    }
    #查询 视频信息
    public function getvideo(Request $request){
        #获取课时的 id
        $class_id=$request->class_id;
        #根据 课时id 查询 课时的视频
        $class_data=DB::table('curr_class_hour')->where(['class_id'=>$class_id,'video_status'=>3])->value('class_data');
        if($class_data){
            return $class_data;
        }else{
            return 2;
        }
    }

    #审核通过
    public function video_pass(Request $request){
        #接受 课时id
        $class_id=$request->class_id;
        #根据课时id 修改 课时表的状态
        $update=DB::table('curr_class_hour')->where(['class_id'=>$class_id])->update(['video_status'=>1]);
        if($update){
            return ['code'=>1,'msg'=>'审核通过成功'];
        }else{
            return ['code'=>5,'msg'=>'审核通过失败'];
        }
    }

    #审核不通过
    public function video_no(Request $request){
        #接受 课时id
        $class_id=$request->class_id;
        #根据课时id 修改 课时表的状态
        $update=DB::table('curr_class_hour')->where(['class_id'=>$class_id])->update(['video_status'=>2]);
        if($update){
            return ['code'=>1,'msg'=>'审核不通过成功'];
        }else{
            return ['code'=>5,'msg'=>'审核不通过失败'];
        }
    }


}
