<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @yield('body_header_title')
        </h1>
        {{--<ol class="breadcrumb">--}}
            {{--@yield('body_breadcrumb')--}}
        {{--</ol>--}}
    </section>

    <!-- Main content -->
    <section class="content">
        {{-- 提示--}}
        @include('common.notify')

        @yield('body_content')
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


