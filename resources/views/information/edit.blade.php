@extends('admin.index')
@section('title', 'Laravel学院')

@section('content')
    <form class="layui-form" action="/formation/edit" method="post">
        <input type="hidden" value="{{$info->info_id}}" name="info_id">
        <div class="layui-form-item">
            <label class="layui-form-label">资讯标题</label>
            <div class="layui-input-inline">
                <input type="text" name="info_title" required value="{{$info->info_title}}" lay-verify="required" placeholder="请输入标题" autocomplete="on" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">资讯介绍</label>
            <div class="layui-input-inline">
                <textarea name="info_desc" placeholder="请输入介绍内容" class="layui-textarea">{{$info->info_desc}}</textarea>
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">资讯详情</label>
            <div class="layui-input-inline">
                <textarea name="info_detail" placeholder="请输入详情内容" class="layui-textarea">{{$info->info_detail}}</textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">资讯分类</label>
            <div class="layui-input-inline">
                <select name="info_cate_id" lay-verify="required">
                    @foreach($res as $k=>$v)
                        @if($info->info_cate_id == $v->info_cate_id)
                            <option value="{{$v->info_cate_id}}">{{$v->info_name}}</option>
                        @else
                            <option value="{{$v->info_cate_id}}">{{$v->info_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

<script>
        //Demo
        layui.use('form', function(){
            var form = layui.form;
        });
    </script>

@endsection