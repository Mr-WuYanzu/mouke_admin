@extends('admin.index')

@section('content')

<table class="layui-table">
  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th>课时id</th>
      <th>课时名称</th>
      <th>课程状态</th>
      <th>添加时间</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($currInfo as $v)
    <tr>
      <td>{{$v['class_id']}}</td>
      <td>{{$v['class_name']}}</td>
      <td>待审核</td>
      <td>{{date('Y-m-d H:i:s',$v->create_time)}}</td>
      <td>
      	<a class="layui-btn layui-btn-normal" href="/video/audit?class_id={{$v['class_id']}}">审核课程视频</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection