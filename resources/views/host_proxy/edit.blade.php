@extends('layouts.master')

    @section('body_header_title')
        代理编辑
    @endsection

    @section('body_breadcrumb')
        {{-- 面包屑导航--}}
        @include('common.breadcrumb')

    @endsection


    @section('body_content')

    {{-- 编辑项 --}}
    @include('host_proxy.edit_form')

    <script src="{{ URL::asset('js/host_proxy/edit.js',getenv('HTTP_SECURE'))}}"></script>

@endsection
