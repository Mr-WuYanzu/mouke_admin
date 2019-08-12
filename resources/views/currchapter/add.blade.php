@extends('admin.index')

@section('content')

<form class="layui-form" method="post"> <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->
  <div class="layui-form-item">
    <label class="layui-form-label">章节名称</label>
    <div class="layui-input-inline">
      <input type="text" id="chapter_name" name="chapter_name" placeholder="请输入章节名称" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">所属课程</label>
    <div class="layui-input-inline">
      <select name="curr_id" id="curr_id" lay-filter="aihao">
      	@foreach($currInfo as $v)
        <option value="{{$v['curr_id']}}">{{$v['curr_name']}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">课程介绍</label>
    <div class="layui-input-block">
      <textarea name="chapter_desc" id="chapter_desc" placeholder="请输入课程介绍" class="layui-textarea"></textarea>
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button type="button" id="sub" class="layui-btn" lay-submit lay-filter="*">立即提交</button>
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
				//获取章节名称
				obj.chapter_name=$('#chapter_name').val();
				//获取所属课程
				obj.curr_id=$('option:selected').val();
				//获取章节介绍
				obj.chapter_desc=$('#chapter_desc').val();
				var reg=/^.{2,}$/;
				var flag=false;

				//非空、正则、唯一性验证
				if(obj.chapter_name==''){
					layer.msg('章节名称必填',{icon:5,time:1000});
					return false;
				}else if(!reg.test(obj.chapter_name)){
					layer.msg('章节名称至少2位',{icon:5,time:1000});
					return false;
				}else{
					$.ajax({
						url:'checkchaptername',
						method:'post',
						async:false,
						data:{chapter_name:obj.chapter_name},
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

				//发送请求,提交数据
				$.post(
					'addHandle',
					{data:obj},
					function(res){
						layer.msg(res.font,{icon:res.skin,time:1000},function(){
							if(res.code==1){
								location.href='/currchapter/list';
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