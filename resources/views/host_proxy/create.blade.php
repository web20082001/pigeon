@extends('layouts.master')

@section('body_header_title')

@endsection

@section('body_breadcrumb')
    {{-- 面包屑导航--}}

@endsection


@section('body_content')

    {{-- 编辑项 --}}
    @include('host_proxy.create_form')


    <script src="{{ URL::asset('js/host_proxy/create.js',getenv('HTTP_SECURE'))}}"></script>
@endsection
