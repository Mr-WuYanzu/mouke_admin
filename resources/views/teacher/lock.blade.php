@extends('admin.index')
@section('title','教师锁定页面')

@section('content')

    <div class="layui-form">
        <table class="layui-table">
            <colgroup>
                <col width="150">
                <col width="150">
                <col width="150">
                <col width="700">
                <col width="150">
                <col width="200">
            </colgroup>
            <thead>
            <input type="hidden" value="{{csrf_token()}}" id="_token">
            <tr>
                <th>讲师名称</th>
                <th>授课方向</th>
                <th>级别</th>
                <th>讲师介绍</th>
                <th>是否锁定</th>
                <th>锁定</th>
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

                    @if($v->status == 2)
                        <td>未锁定</td>
                    @else($v->status == 4)
                        <td>已锁定</td>
                    @endif

                    <td>
                        <div class="layui-btn-group" >
                            <button type="button"  class="layui-btn btn1" t_id="{{$v->t_id}}">锁定</button>
                            <button type="button"  class="layui-btn btn2" t_id="{{$v->t_id}}">解锁</button>
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
        layui.use(['layer'],function () {
            var layer = layui.layer;


            $(document).on('click','.btn1',function(){
                // alert(1111);
                var _token = $("#_token").val();
                var t_id = $(this).attr('t_id');
                $.post(
                    '/teacherlock',
                    {t_id:t_id,_token:_token},
                    function(res){
                        var code = res.code;
                        if(code == 200){
                            layer.msg(res.msg,{icon:6});
                        }else if(code == 201){
                            layer.msg(res.msg,{icon:2});
                        }else if(code == 402){
                            layer.msg(res.msg,{icon:2});
                        }
                    }
                )
                history.go(0);
            })

            $(document).on('click','.btn2',function(){
                // alert(1111);
                var _token = $("#_token").val();
                var t_id = $(this).attr('t_id');
                $.post(
                    '/teacherlock1',
                    {t_id:t_id,_token:_token},
                    function(res){
                        var code = res.code;
                        if(code == 200){
                            layer.msg(res.msg,{icon:6});
                        }else if(code == 201){
                            layer.msg(res.msg,{icon:2});
                        }else if(code == 402){
                            layer.msg(res.msg,{icon:2});
                        }
                    }
                )
                history.go(0);
            })
        })
    })

</script>






