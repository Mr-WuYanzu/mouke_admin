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
                <a href="/cate_del/{{$v->info_cate_id}}"><button type="button" class="btn btn-info">删除</button></a>
            </td>
        </tr>
        </tbody>
        @endforeach
    </table>
@endsection