@extends('layouts.master')

    @section('body_header_title')

    @endsection

    @section('body_breadcrumb')

        {{-- 面包屑导航--}}
        @include('common.breadcrumb')

    @endsection

    @section('body_content')

        {{-- 菜单导航--}}
        @include('role.page_header')

        {{-- 表格--}}
        @include('role.index_search')

        {{-- 表格--}}
        @include('role.data_table')

    @endsection