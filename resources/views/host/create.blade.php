@extends('layouts.master')

@section('body_header_title')

@endsection

@section('body_breadcrumb')
    {{-- 面包屑导航--}}

@endsection


@section('body_content')

    {{-- 编辑项 --}}
    @include('host.create_form')

    <script type="text/javascript" src="{{ asset('js/WdatePicker.js') }}"></script>
@endsection
