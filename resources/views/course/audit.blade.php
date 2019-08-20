@extends('admin.index')
@section('title', '课程审核')

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
            <th>课程状态</th>
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
            <td>
                <button class="layui-btn layui-btn-radius layui-btn-normal" curr_id="{{$v->curr_id}}">审核通过</button>
                <button class="layui-btn layui-btn-radius layui-btn-danger" curr_id="{{$v->curr_id}}">审核不通过</button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
<script>
     $(function() {
         layui.use(['layer'], function () {
             var layer = layui.layer;

             //点击审核通过
             $('.layui-btn-normal').click(function () {
                 //获取课程的id
                 var curr_id = $(this).attr('curr_id');
                     $.post(
                         "/audit_pass",
                         {curr_id: curr_id},
                         function (res) {
                             // console.log(res);
                             if (res.code == 1) {
                                 layer.msg(res.msg, {icon: res.code,time:2000},function(){
                                     location.href='/course/audit';
                                 });
                             } else {
                                 layer.msg(res.msg, {icon: res.code});
                             }
                         }
                     )
             })

             //点击审核不通过
             $('.layui-btn-danger').click(function(){
                 //拿到审核不通过的原因
                 var text=prompt('输入审核不通过的原因','')
                 if(text == ''){
                     layer.msg('请输入不通过审核的原因', {icon: 5});
                     return false;
                 }
                 //获取课程的id
                 var curr_id = $(this).attr('curr_id');
                 $.post(
                     "/audit_no",
                     {text:text,curr_id:curr_id},
                     function(res){
                         // console.log(res);
                         if(res.code == 1){
                             layer.msg(res.msg, {icon: res.code,time:2000},function(){
                                 location.href='/course/audit';
                             });
                         }else{
                             layer.msg(res.msg, {icon: res.code,time:2000});
                         }
                     }
                 )

             })

         })
     })
</script>

@endsection