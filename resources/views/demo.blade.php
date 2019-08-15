@extends('admin/index')

@section('content')

<button id='sub'>test</button>

<script type="text/javascript">
	$(function(){
		layui.use(['layer'],function(){
			var layer=layui.layer;

			$('#sub').click(function(){
				$.post(
					'/demo/demo',
					function(res){
						layer.msg(res.font,{icon:res.skin,time:1000});
					},
					'json'
				)
			});
		});
	});
</script>

@endsection