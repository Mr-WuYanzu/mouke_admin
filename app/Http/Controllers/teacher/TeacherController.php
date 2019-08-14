<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TeacherModel;
use App\Model\CurrModel;
use DB;

class TeacherController extends Controller
{
    /**
     * 讲师展示页面
     */
     public function teacherlist(Request $request)
     {
        $data = DB::table('teacher')
                ->join('curr','teacher.curr_id','=','curr.curr_id')
                ->get();
        return view('teacher.teacherlist',['data'=>$data]);
     }
     /**
      * 讲师审核页面
      */
     public function teacherreview(Request $request)
     {
        $t_id = $request->post('t_id');
        $status = collect(TeacherModel::where(['t_id'=>$t_id])->get())->toArray();
        $status = $status[0]['status'];

        if($status==2){
            echo "3";die;
        }elseif($status == 3){
            echo "3";die;
        }elseif($status == 4){
            echo "4";die;
        }else{
            $res = TeacherModel::where(['t_id'=>$t_id])->update(['status'=>2]);
            if($res == 1){
                echo 1;die;
            }else{
                echo 2;die;
            }
        }
//        echo $res;die;



        //  return view('teacher.teacherreview');
     }
    /**
     * 讲师审核失败页面
     */
    public function teacherreview1(Request $request)
    {
        $t_id = $request->post('t_id');
        $status = collect(TeacherModel::where(['t_id'=>$t_id])->get())->toArray();
        $status = $status[0]['status'];

        if($status==3){
            echo "3";die;
        }elseif($status==2){
            echo "3";die;
        }else if($status == 4){
            echo "4";die;
        }else{
            $res = TeacherModel::where(['t_id'=>$t_id])->update(['status'=>3]);
            if($res == 1){
                echo 1;die;
            }else{
                echo 2;die;
            }
        }
    }
    /**
     * 讲师锁定页面
     */
    public function lock()
    {
        $data = TeacherModel::where(['status'=>2])->orWhere(['status'=>4])->get();
//        dd($data);
        return view('teacher.lock',['data'=>$data]);
    }

     /**
      * 讲师锁定页面
      */
      public function teacherlock(Request $request)
      {
          $t_id = $request->post('t_id');
          $status = collect(TeacherModel::where(['t_id'=>$t_id])->get())->toArray();
          $status = $status[0]['status'];
          if($status == 2){
              $res = TeacherModel::where(['t_id'=>$t_id])->update(['status'=>4]);
              if($res == 1){
                  return ['code'=>200,'msg'=>'锁定成功'];
              }else{
                  return ['code'=>201,'msg'=>'锁定失败'];
              }

          }else if($status == 4){
              return ['code'=>402,'msg'=>'已锁定！'];
          }
      }

    /**
     * 讲师解锁页面
     */
    public function teacherlock1(Request $request)
    {
        $t_id = $request->post('t_id');
        $status = collect(TeacherModel::where(['t_id'=>$t_id])->get())->toArray();
        $status = $status[0]['status'];
        if($status == 4){
            $res = TeacherModel::where(['t_id'=>$t_id])->update(['status'=>2]);
            if($res == 1){
                return ['code'=>200,'msg'=>'解锁成功'];
            }else{
                return ['code'=>201,'msg'=>'解锁失败'];
            }
//              echo "锁定成功";die;
        }else if($status == 2){
            return ['code'=>402,'msg'=>'已解锁！'];
        }
    }
 

}
