@extends('layouts.app')
@section('title',trans('menu.workshop'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
    <link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
@endsection
@section('content')
    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('menu.workshop')</span>
            </h3>
        </div>
        <div class="card mb-5">
            <div class="card-body">
                <workshop-edit note="{!! e($workshop->note) !!}"></workshop-edit>
            </div>
        </div>

    </div>
@endsection

