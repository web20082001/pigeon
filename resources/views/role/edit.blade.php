@extends('layouts.master')

    @section('body_header_title')
        角色权限编辑
    @endsection

    @section('body_breadcrumb')
        {{-- 面包屑导航--}}
        @include('common.breadcrumb')

    @endsection


    @section('body_content')

    {{-- 编辑项 --}}
    @include('role.edit_form')

    <script src="{{ URL::asset('js/role/edit.js',getenv('HTTP_SECURE'))}}"></script>

@endsection
