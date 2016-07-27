@extends('layouts.master')

    @section('body_header_title')
        主机管理
    @endsection


    @section('body_breadcrumb')

    @endsection


    @section('body_content')

        {{-- 菜单导航--}}
        @include('area.page_header')


        {{-- 表格--}}
        @include('area.data_table')




    @endsection

