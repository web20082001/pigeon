@extends('layouts.master')

    @section('body_header_title')

    @endsection

    @section('body_breadcrumb')

        {{-- 面包屑导航--}}
        @include('common.breadcrumb')

    @endsection

    @section('body_content')

        {{-- 菜单导航--}}
        @include('task.page_header')

        {{-- 表格--}}
        @include('task.index_search')

        {{-- 表格--}}
        @include('task.data_table')

        <script type="text/javascript" src="{{ asset('js/WdatePicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/task/index.js') }}"></script>

    @endsection