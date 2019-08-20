@extends('admin.index')
@section('title', 'Laravel学院')

@section('content')

    <form class="layui-form" action="/cate_do" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">资讯分类名</label>
            <div class="layui-input-inline">
                <input type="text" name="c_name" required  lay-verify="required" placeholder="请输入名称" autocomplete="on" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

    <script>
        //Demo
        layui.use('form', function(){
            var form = layui.form;
            var layer = layui.layer;
            //点击提交
            form.on('submit(formDemo)', function(data){
                //console.log(data.field);
                $.post(
                    "/cate_do",
                    data.field,
                    function(res){
                        // console.log(res);
                        if(res.code==1){
                            layer.msg(res.msg,{icon:res.code});
                        }else if(res.code==2){
                            layer.msg(res.msg,{icon:res.code,time:2000},function(){
                            location.href='/cate_formation/add';
                            });
                        }else{
                            layer.msg(res.msg,{icon:res.code});
                        }
                    }
                )
                return false;
            });



        });
    </script>

@endsection