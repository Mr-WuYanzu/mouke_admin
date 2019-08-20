@extends('admin.index')
@section('title', '视频审核')

@section('content')
    {{--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}

        <div class="layui-form-item">
            <label class="layui-form-label">视频</label>
            <div class="layui-input-block" id="class_video" class_id="{{$classInfo['class_id']}}">
                <video src="http://curr.video.com/{{$classInfo['class_data']}}"></video>
            </div>
        </div>


        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="button" class="btn btn-success">审核通过</button>
                <button type="button" class="btn btn-danger">审核不通过</button>
            </div>
        </div>

    </form>

<script>
    $(function() {
        layui.use(['layer', 'form'], function () {
            var layer = layui.layer;
            var form = layui.form;

            //点击审核通过
            $('.btn-success').click(function(){
                //获取课时id
                var class_id = $('#class_video').attr('class_id');
                $.post(
                    "/video_pass",
                    {class_id:class_id},
                    function(res){
                        // console.log(res);
                        if(res.code == 1){
                            layer.msg(res.msg,{icon:res.code,time:2000},function(){
                                history.go(0);
                            });
                        }else{
                            layer.msg(res.msg,{icon:res.code,time:2000});
                        }
                    }
                )
            })

            //点击审核不通过
            $('.btn-danger').click(function(){
                //获取课时id
                var class_id=$(this).parents('div').find("input[type=hidden]").val();
                $.post(
                    "/video_no",
                    {class_id:class_id},
                    function(res){
                        // console.log(res);
                        if(res.code == 1){
                            layer.msg(res.msg,{icon:res.code,time:2000});
                        }else{
                            layer.msg(res.msg,{icon:res.code,time:2000});
                        }
                    }
                )
            })

        })
    })
</script>

@endsection