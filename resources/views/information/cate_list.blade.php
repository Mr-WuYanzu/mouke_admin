@extends('admin.index')
@section('title', 'Laravel学院')

@section('content')
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>资讯分类名称</th>
            <th>操作</th>
        </tr>
        </thead>
        @foreach($res as $k=>$v)
        <tbody>
        <tr>
            <td>{{$v->info_name}}</td>
            <td>
                <button type="button" class="btn btn-info" info_cate_id="{{$v->info_cate_id}}">删除</button>
            </td>
        </tr>
        </tbody>
        @endforeach
    </table>
    <script>
        //Demo
        layui.use('form', function(){
            var form = layui.form;
            var layer = layui.layer;

            $('.btn-info').click(function(){
                var info_cate_id=$(this).attr('info_cate_id');
                $.post(
                    "/cate_del",
                    {info_cate_id:info_cate_id},
                    function(res){
                        // console.log(res);
                        if(res.code==1){
                            layer.msg(res.msg,{icon:res.code,time:2000},function(){
                                location.href='/cate_formation/list';
                            });
                        }else{
                            layer.msg(res.msg,{icon:res.code});
                        }
                    }
                )
            })
        });
    </script>





@endsection