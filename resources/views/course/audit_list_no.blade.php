@extends('admin.index')
@section('title', '课程审核未通过列表')

@section('content')

    <table class="layui-table">
        <colgroup>
            <col width="100">
            <col width="100">
            <col width="100">
            <col width="100">
        </colgroup>
        <thead>
        <tr>
            <th>课程名称</th>
            <th>课程图片</th>
            <th>课程介绍</th>
            <th>不通过原因</th>
        </tr>
        </thead>

        <tbody>
        @foreach($courseInfo as $k=>$v)
            <tr>
                <td>{{$v->curr_name}}</td>
                <td>
                    <img src="http://curr.img.com/{{$v->curr_img}}" >
                </td>
                <td>{{$v->curr_detail}}</td>
                <td>{{$v->update_text}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection