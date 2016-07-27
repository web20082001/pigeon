<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title')</title>
        {{-- 框架资源，固定不变--}}
        @include('common.framework_resource')

        {{-- 底部js--}}
        @include('common.footer_resource')
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            {{-- 自定义加载通用的--}}
            @include('common.main_header')

            {{-- 菜单导航--}}
            @include('common.navbar')

            {{-- 主体内容--}}
            @include('common.content')

            {{-- 底部js--}}
            @include('common.footer')

        </div>
        <!-- /wrapper -->

        {{-- 自定义加载通用的--}}
        @include('common.common_resource')
    </body>
</html>