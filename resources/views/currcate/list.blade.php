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
      <th>查看子分类</th>
      <th>分类id</th>
      <th>分类名称</th>
      <th>添加时间</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
  	@foreach($cateInfo as $v)
    <tr cate_id="{{$v['curr_cate_id']}}" pid="{{$v['pid']}}" style="display:none;">
      <td>
      	{!!str_repeat("&ensp;",$v['level']*4)!!}
      	<span class="cate" style="cursor:pointer;">+</span>
      </td>
      <td>{{$v['curr_cate_id']}}</td>
      <td class="cate_name_tr">{{$v['cate_name']}}</td>
      <td>{{date('Y-m-d H:i:s',$v['create_time'])}}</td>
      <td>
      	<a class="layui-btn layui-btn-normal edit" href="/currcate/edit?curr_cate_id={{$v['curr_cate_id']}}">修改</a>
      	<a class="layui-btn layui-btn-danger del">删除</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<script type="text/javascript">
	$(function(){
		layui.use(['layer'],function(){
			var layer=layui.layer;

			//显示分类信息
			function showTr(cate_id){
				$('tr').each(function(index){
					var _this=$(this);
					if(_this.attr('pid')==cate_id){
						_this.show();
					}
				});
			}
			//隐藏分类信息
			function hideTr(cate_id){
				$('tr').each(function(index){
					var _this=$(this);
					if(_this.attr('pid')==cate_id){
						_this.hide();
						_this.find('span.cate').html('+');
						hideTr(_this.attr('cate_id'));
					}
				});
			}

			//展示所有顶级分类
			showTr(0);

			//点击加号变减号展示分类,减号变加号隐藏分类
			$('.cate').click(function(){
				var _this=$(this);
				var cate_id=_this.parents('tr').attr('cate_id');
				if(_this.html()=='+'){
					_this.html('-');
					showTr(cate_id);
				}else if(_this.html()=='-'){
					_this.html('+');	
					hideTr(cate_id);		
				}
			});

			//分类名称即点即改
			$('.cate_name_tr').click(function(){
				var _this=$(this);
				var cate_name=_this.html();
				var curr_cate_id=_this.parents('tr').attr('cate_id');

				if(_this.children('input').length>0){
					return false;
				}

				var _input=$("<input class='cate_name'>").css({'border-width':0,'background-color':_this.css('background-color')}).val(cate_name);

				_this.html(_input);

				_this.children('input').focus().select();

				_this.children('input').keyup(function(e){

					var keyCode=e.keyCode;

					if(keyCode==13){
						var c_name=_this.children('input').val();

						if(c_name==''){
			              layer.msg('请输入章节名称',{icon:5,time:1000});
			              _this.empty();
			              _this.html(cate_name);
			              return false;
			            }

						$.post(
							'editCateName',
							{curr_cate_id:curr_cate_id,cate_name:c_name},
							function(res){
								layer.msg(res.font,{icon:res.skin,time:1000},function(){
									_this.empty();
									if(res.code==1){
										_this.html(c_name);
									}else{
										_this.html(cate_name);
									}
								});
							},
							'json'
						)
					}else if(keyCode==27){
						layer.msg('您取消了修改',{icon:5,time:1000});
						_this.empty();
						_this.html(cate_name);
					}
				});

				_this.children('input').blur(function(){
					_this.empty();
					_this.html(cate_name);
				});

			});

			//删除分类数据
			$('.del').click(function(){
				var _this=$(this);
				var curr_cate_id=_this.parents('tr').attr('cate_id');
				layer.confirm('您确定要删除吗?',function(index){
					$.post(
						'del',
						{curr_cate_id:curr_cate_id},
						function(res){
							layer.msg(res.font,{icon:res.skin,time:1000},function(){
								if(res.code==1){
									_this.parents('tr').remove();
								}
							});
						},
						'json'
					)
				});
			});

		});
	});
</script>

@endsection