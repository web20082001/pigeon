@extends('layouts.master')

@section('body_header_title')

@endsection

@section('body_breadcrumb')
    {{-- 面包屑导航--}}
    @include('common.breadcrumb')

@endsection


@section('body_content')

    {{-- 编辑项 --}}
    @include('task.create_form')


    <script src="{{ URL::asset('js/task/create.js',getenv('HTTP_SECURE'))}}"></script>
@endsection
