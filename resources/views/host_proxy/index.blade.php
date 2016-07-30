@extends('layouts.master')

    @section('body_header_title')

    @endsection

    @section('body_breadcrumb')

        {{-- 面包屑导航--}}
        {{--@include('common.breadcrumb')--}}

        <h2 class="ui dividing header">{{$sub_title or ''}}</h2>

    @endsection

    @section('body_content')

        {{-- 菜单导航--}}
        @include('host_proxy.page_header')

        {{-- 表格--}}
        @include('host_proxy.index_search')

        {{-- 表格--}}
        @include('host_proxy.data_table')

    @endsection