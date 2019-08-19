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
      <th>课程id</th>
      <th>课程名称</th>
      <th>课程图片</th>
      <th>课程状态</th>
      <th>课程介绍</th>
      <th>课程分类</th>
      <th>添加时间</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($currInfo as $v)
    <tr>
      <td>{{$v->curr_id}}</td>
      <td>{{$v->curr_name}}</td>
      <td><img src="{{$v->curr_img}}" width="30"></td>
      <td>{{$v->status==1?'完结':'更新中'}}</td>
      <td>{{str_replace(mb_substr($v['curr_detail'],8,mb_strlen($v['curr_detail'])),'...',$v['curr_detail'])}}</td>
      <td>{{$v->cate->cate_name}}</td>
      <td>{{date('Y-m-d H:i:s',$v->create_time)}}</td>
      <td>
      	<a class="layui-btn layui-btn-normal" href="/video/audit?curr_id={{$v->curr_id}}">审核课程视频</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection