@extends('layouts.master')

    @section('body_header_title')
        任务编辑
    @endsection

    @section('body_breadcrumb')
        {{-- 面包屑导航--}}
        @include('common.breadcrumb')

    @endsection


    @section('body_content')

    {{-- 编辑项 --}}
    @include('task.edit_form')

    <script type="text/javascript" src="{{ asset('js/WdatePicker.js') }}"></script>

@endsection
