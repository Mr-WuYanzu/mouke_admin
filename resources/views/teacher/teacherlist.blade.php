@extends('teacher.index')
@section('title','讲师展示页面');


@section('content')

<div class="layui-form">
  <table class="layui-table">
    <colgroup>
      <col width="150">
      <col width="150">
      <col width="150">
      <col width="700">
      <col width="150">
      <col width="250">
    </colgroup>
    <thead>
      <input type="hidden" value="{{csrf_token()}}" id="_token">
      <tr>
        <th>讲师名称</th>
        <th>授课方向</th>
        <th>级别</th>
        <th>讲师介绍</th>
        <th>审核状态</th>
        <th>审核</th>
      </tr> 
    </thead>
    <tbody>
        @foreach($data as $v)

        <tr>
            <td>{{$v->t_name}}</td>
            <td>{{$v->curr_name}}</td>
            @if($v->t_good == 1)
              <td>优秀讲师</td>
            @else
              <td>普通讲师</td>
            @endif
            <td>{{$v->t_desc}}</td>

            @if($v->status == 1)
              <td class='tt'><span>待审核</span></td>
            @elseif($v->status == 2)
              <td class='tt'><span>审核通过</span></td>
            @else
              <td class='tt'><span>审核未通过</span></td>
            @endif
            
            <td>
              <div class="layui-btn-group" >
                <button type="button" class="layui-btn btn1" t_id="{{$v->t_id}}">通过审核</button>
                <button type="button" class="layui-btn btn2" t_id="{{$v->t_id}}">拒绝审核</button>
              </div>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endsection


<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/layui/layui.js"></script>
<script src="/layui/css/layui.css"></script>

<script>
  $(function(){ 
      layui.use(['layer'],function(){
        var layer = layui.layer;

          $(document).on('click','.btn1',function(){
            var _token = $("#_token").val();
            var t_id = $(this).attr('t_id');
            var tt = $(this).parents('td').prev().find('span');
            $.post(
              '/teacherreview',
              {t_id:t_id,_token:_token},
              function(res){
                console.log(res);
                if(res==1){
                    layer.msg('审核通过！',{icon:6});
                }else if(res == 2){
                    layer.msg('审核失败',{icon:2});
                }else if(res == 3){
                    layer.msg('已经审核过了',{icon:7});
                }else if(res == 4){
                    layer.msg('已锁定无法审核',{icon:2});
                }
              }
            )
              history.go(0);
          })

          $(document).on('click','.btn2',function(){
              var _token = $("#_token").val();
              var t_id = $(this).attr('t_id');
              var tt = $(this).parents('td').prev().find('span');
              $.post(
                  '/teacherreview1',
                  {t_id:t_id,_token:_token},
                  function(res){
                      console.log(res);
                      if(res==1){
                          layer.msg('拒绝审核成功',{icon:6});
                      }else if(res == 2){
                          layer.msg('审核失败',{icon:2});
                      }else if(res == 3){
                          layer.msg('已经审核过了',{icon:7});
                      }else if(res == 4){
                          layer.msg('锁定状态，无法审核',{icon:2})
                      }
                  }
              )
              history.go(0);
          })
        })
      })
</script>