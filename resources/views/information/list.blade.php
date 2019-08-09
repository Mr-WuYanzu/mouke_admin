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
            <th>资讯标题</th>
            <th>资讯介绍</th>
            <th>资讯内容</th>
            <th>资讯分类</th>
            <th>操作</th>
        </tr>
        </thead>
        @foreach($res as $k=>$v)
            <tbody>
            <tr>
                <td>{{$v['info_title']}}</td>
                <td>{{$v['info_desc']}}</td>
                <td>{{$v['info_detail']}}</td>
                <td>{{$v['info_name']}}</td>
                <td>
                    <button class="layui-btn layui-btn-danger" info_id="{{$v['info_id']}}">删除</button>
                    <a href="/formation/update/{{$v['info_id']}}"><button class="layui-btn layui-btn-warm">修改</button></a>
                </td>
            </tr>
            </tbody>
        @endforeach
    </table>

<script>
    $(function(){
        //删除
        $('.layui-btn-danger').click(function(){
            var info_id=$(this).attr('info_id');
            $.post(
                '/formation/del',
                {info_id:info_id},
                function(res){
                    if(res==1){
                        alert('删除成功');
                        location.href='/formation/list';
                    }else{
                        alert('删除失败-->请重试');
                    }
                }
            )
        })
    })
</script>

@endsection