{{--头部--}}
        @section('top')
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
                <title>管理员后台</title>
                <link rel="stylesheet" href="/layui/css/layui.css">
                <script src="/layui/layui.js"></script>
                <script src="/js/jquery.js"></script>
            </head>
            <body class="layui-layout-body">

            <div class="layui-layout layui-layout-admin">
            <div class="layui-header">
                <div class="layui-logo">管理员后台</div>

        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
            <li class="layui-nav-item"><a href="">商品管理</a></li>
            <li class="layui-nav-item"><a href="">用户</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    贤心
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="">退了</a></li>
        </ul>
    </div>
        @show

    {{--左侧--}}
    @section('left')
        <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">

                <li class="layui-nav-item">
                    <a href="javascript:;">讲师管理模块</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/teacherlist">讲师列表审核</a></dd>
                        <dd><a href="/lock">讲师列表锁定</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    @show

    {{--主体--}}
    <div class="layui-body">
        <div style="padding: 15px;">@yield('content')</div>
    </div>

    {{--底部--}}
    @section('footer')
        <div class="layui-footer">
        <!-- 底部固定区域 -->
        © layui.com - 底部固定区域
    </div>
        </div>
        <script>
            //JavaScript代码区域
            layui.use('element', function(){
                var element = layui.element;
            });
        </script>
        </body>
        </html>
    @show