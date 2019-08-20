@extends('admin.index')
@section('title', 'Laravel学院')

@section('content')
    <form class="layui-form" action="/formation/add_do" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">资讯标题</label>
            <div class="layui-input-inline">
                <input type="text" name="info_title" required  lay-verify="required" placeholder="请输入标题" autocomplete="on" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">资讯介绍</label>
            <div class="layui-input-inline">
                <textarea name="info_desc" placeholder="请输入介绍内容" class="layui-textarea"></textarea>
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">资讯详情</label>
            <div class="layui-input-inline">
                <textarea name="info_detail" placeholder="请输入详情内容" class="layui-textarea"></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">资讯分类</label>
            <div class="layui-input-inline">
                <select name="c_id" lay-verify="required">
                        <option value=""></option>
                    @foreach($res as $k=>$v)
                        <option value="{{$v->info_cate_id}}">{{$v->info_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo" id="submit">立即提交</button>
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
                    "/formation/add_do",
                    data.field,
                    function(res){
                        // console.log(res);
                        if(res.code==1){
                            layer.msg(res.msg,{icon:res.code});
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