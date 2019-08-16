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
      <th>章节id</th>
      <th>章节名称</th>
      <th>章节介绍</th>
      <th>所属课程</th>
      <th>添加时间</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
  	@foreach($chapterInfo as $v)
    <tr chapter_id="{{$v['chapter_id']}}">
      <td>{{$v['chapter_id']}}</td>
      <td class="chapter_td">{{$v['chapter_name']}}</td>
      <td>{{str_replace(mb_substr($v['chapter_desc'],8,mb_strlen($v['chapter_desc'])),'...',$v['chapter_desc'])}}</td>
      <td>{{$v['curr']['curr_name']}}</td>
      <td>{{date('Y-m-d H:i:s',$v['create_time'])}}</td>
      <td>
      	<a class="layui-btn layui-btn-normal edit" href="/currchapter/edit?chapter_id={{$v['chapter_id']}}">修改</a>
      	<a class="layui-btn layui-btn-danger del">删除</a>
      </td>
     @endforeach
    </tr>
  </tbody>
</table>

<script type="text/javascript">
	$(function(){
		layui.use(['layer'],function(){
			var layer=layui.layer;

      //即点即改章节名称
      $('.chapter_td').click(function(){
        var _this=$(this);
        var chapter_name=_this.html();
        var chapter_id=_this.parents('tr').attr('chapter_id');

        if(_this.children('input').length>0){
          return false;
        }

        var input=$("<input class='chapter_name'>").css({'border-width':0,'background-color':_this.css('background-color')}).val(chapter_name);
        _this.html(input);
        _this.children('input').focus().select();

        _this.children('input').keyup(function(e){
          var keyCode=e.keyCode;
          var c_name=_this.children('input').val();

          if(keyCode==13){

            if(c_name==''){
              layer.msg('请输入章节名称',{icon:5,time:1000});
              _this.empty();
              _this.html(chapter_name);
              return false;
            }

            $.post(
              'editChapterName',
              {chapter_id:chapter_id,chapter_name:c_name},
              function(res){
                layer.msg(res.font,{icon:res.skin,time:1000},function(){
                  _this.empty();
                  if(res.code==1){
                    _this.html(c_name);
                  }else{
                    _this.html(chapter_name);
                  }
                });
              },
              'json'
            )

          }else if(keyCode==27){
            layer.msg('您取消了修改',{icon:5,time:1000},function(){
              _this.empty();
              _this.html(chapter_name);
            });
          }
        });

        _this.children('input').blur(function(){
          _this.empty();
          _this.html(chapter_name);
        });
      });

			//删除数据
			$('.del').click(function(){
				var _this=$(this);
				var chapter_id=_this.parents('tr').attr('chapter_id');
				layer.confirm('您确定要删除吗?',function(index){
					$.post(
						'del',
						{chapter_id:chapter_id},
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