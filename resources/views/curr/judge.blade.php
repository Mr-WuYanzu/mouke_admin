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
      <th>是否付费</th>
      <th>添加时间</th>
      <th>评判课程</th>
    </tr> 
  </thead>
  <tbody>
  	@foreach($currInfo as $v)
    <tr curr_id='{{$v->curr_id}}'>
      <td>{{$v->curr_id}}</td>
      <td>{{$v->curr_name}}</td>
      <td>
      	<img src="http://curr.img.com/{{$v->curr_img}}" width="50" height="30">
      </td>
      <td>{{$v->status==1?'已完结':'更新中'}}</td>
      <td>{{$v->curr_detail}}</td>
      <td>{{$v->is_pay==1?'免费':'付费'}}</td>
      <td>{{date('Y-m-d H:i:s',$v->create_time)}}</td>
      <td>
      	@if($v->curr_good==1)
      	<a class="layui-btn layui-btn-normal judge" type="2">设为精品课程</a>
      	@elseif($v->curr_good==2)
      	<a class='layui-btn layui-btn-warm judge' type="1">设为普通课程</a>
      	@endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<script type="text/javascript">
	$(function(){
		layui.use(['layer'],function(){

			$('.judge').click(function(){
				var _this=$(this);
				var obj={};
				obj.curr_id=_this.parents('tr').attr('curr_id');
				obj.curr_good=_this.attr('type');
				$.post(
					'judgeDo',
					{data:obj},
					function(res){
						layer.msg(res.font,{icon:res.skin,time:1000},function(){
							if(res.code==1){
								history.go(0);
							}
						});
					},
					'json'
				)
			});
		});
	});
</script>

@endsection