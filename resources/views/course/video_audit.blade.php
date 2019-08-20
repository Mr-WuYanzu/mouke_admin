@extends('admin.index')
@section('title', '视频审核')

@section('content')
    {{--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}
    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">选择课程</label>
            <div class="layui-input-inline">
                <select name="curr_id" id="curr_id" lay-filter='curr' lay-verify="required">
                    <option value="">请选择课程</option>
                    @foreach($currInfo as $v)
                        <option value="{{$v->curr_id}}">{{$v->curr_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">选择章节</label>
            <div class="layui-input-inline">
                <select name="chapter_id" id="chapter_id" lay-filter='chapter' lay-verify="required">
                    <option value="">请选择章节</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">选择课时</label>
            <div class="layui-input-inline">
                <select name="class_id" id="class_id" lay-filter='class' lay-verify="required">
                    <option value="">请选择课时</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">视频</label>
            <div class="layui-input-block" id="class_video">
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

            //选择课程,展示课程下的章节
            form.on('select(curr)',function(data){
                var curr_id=data.value;
                if(curr_id==''){
                    layer.msg('请选择一个课程',{icon:5,time:1000});
                    $('#chapter_id').empty();
                    $('#chapter_id').append(new Option('请选择章节',''));
                    $('#class_id').empty();
                    $('#class_id').append(new Option('请选择章节',''));
                    form.render();
                    return false;
                }
                $.post(
                    '/curriculum',
                    {curr_id:curr_id},
                    function(res){
                        if(res!=2){
                            for(i in res){
                                $('#chapter_id').append(new Option(res[i]['chapter_name'],res[i]['chapter_id']));
                            }
                        }else{
                            $('#chapter_id').empty();
                            $('#chapter_id').append(new Option('请选择章节',''));
                        }
                        form.render();
                    }
                )
            });

            //选择章节 展示章节下的课时
            form.on('select(chapter)',function(data) {
                var chapter_id = data.value;
                if (chapter_id == '') {
                    layer.msg('请选择一个章节', {icon: 5, time: 1000});
                    return false;
                }

                $.post(
                    '/class_hour',
                    {chapter_id:chapter_id},
                    function(res){
                        if(res!=2){
                            for(i in res){
                                var _hidden="<input type='hidden' value="+res[i]['class_id']+">";
                                $('#class_id').append(new Option(res[i]['class_name'],res[i]['class_id']));
                                $('#class_id').append(_hidden);
                            }
                        }else{
                            $('#class_id').empty();
                            $('#class_id').append(new Option('请选择章节',''));
                        }
                        form.render();
                    }
                )
            })

            //选择课时 展示课时下的视频
            form.on('select(class)',function(data){
                var class_id=data.value;

                if(class_id==''){
                    layer.msg('请选择一个课时',{icon:5,time:1000});
                    return false;
                }

                $.post(
                    '/getvideo',
                    {class_id:class_id},
                    function(res){
                        if(res!=2){
                            var _video="<video controls='controls' src='http://curr.video.com/"+res+"'></video>";
                            if($('#class_video').children().is('video')!=true){
                                $('#class_video').append(_video);
                            }
                        }else{
                            layer.msg('该课时还未上传视频,请耐心等待',{icon:5,time:1000});
                            $('#class_video').empty();
                        }
                    }
                )
            });

            //点击审核通过
            $('.btn-success').click(function(){
                //获取课时id
                var class_id=$(this).parents('div').find("input[type=hidden]").val();
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