@extends('layouts.master')

@section('body_header_title')

@endsection

@section('body_breadcrumb')
    {{-- 面包屑导航--}}
    @include('common.breadcrumb')

@endsection


@section('body_content')

    {{-- 编辑项 --}}
    @include('software.create_form')

@endsection
