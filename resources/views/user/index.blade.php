@extends('layouts.master')

    @section('body_header_title')

    @endsection

    @section('body_breadcrumb')

        {{-- 面包屑导航--}}
        @include('common.breadcrumb')


    @endsection

    @section('body_content')

        {{-- 菜单导航--}}
        @include('user.page_header')

        {{-- 表格--}}
        @include('user.index_search')

        {{-- 表格--}}
        @include('user.data_table')

    @endsection