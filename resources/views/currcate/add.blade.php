@extends('admin.index')

@section('content')

<form class="layui-form" method="post"> <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->
  <div class="layui-form-item">
    <label class="layui-form-label">分类名称</label>
    <div class="layui-input-inline">
      <input type="text" name="cate_name" id="cate_name" placeholder="请输入分类名称" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">父级分类</label>
    <div class="layui-input-inline">
      <select name="pid" id="pid" lay-filter="aihao">
        <option value="0">顶级分类</option>
        @foreach($cateInfo as $v)
        <option value="{{$v['curr_cate_id']}}">{!!str_repeat("&ensp;",$v['level']*4)!!}{{$v['cate_name']}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" id="sub" lay-submit lay-filter="*">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
  <!-- 更多表单结构排版请移步文档左侧【页面元素-表单】一项阅览 -->
</form>

<script type="text/javascript">
	$(function(){
		layui.use(['layer','form'],function(){
			var layer=layui.layer;
			var form=layui.form;

			$('#sub').click(function(){
				var obj={};
				obj.cate_name=$('#cate_name').val();
				obj.pid=$('option:checked').val();
				var reg=/^.{2,}$/;
				var flag=false;

				if(obj.cate_name==''){
					layer.msg('分类名称必填',{icon:5,time:1000});
					return false;
				}else if(!reg.test(obj.cate_name)){
					layer.msg('分类名称至少2位',{icon:5,time:1000});
					return false;
				}else{
					$.ajax({
						url:'checkCateName',
						method:'post',
						async:false,
						data:{cate_name:obj.cate_name},
						success:function(res){
							if(res.code==2){
								layer.msg(res.font,{icon:res.skin,time:1000});
								flag=false;
							}else{
								flag=true;
							}
						},
						dataType:'json'
					});

					if(flag==false){
						return false;
					}
				}

				$.post(
					'addHandle',
					{data:obj},
					function(res){
						layer.msg(res.font,{icon:res.skin,time:1000},function(){
							if(res.code==1){
								location.href='/currcate/list';
							}
						});
					},
					'json'
				)

				return false;
			});
		});
	});
</script>

@endsection