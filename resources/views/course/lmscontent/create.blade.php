@extends('layouts.app')
@section('title',trans('form.add_content'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
    <link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>@lang('form.add_content')</span>
        </h3>
    </div>
    <v-app>
        <add-lms is-edit="false"></add-lms>
    </v-app>
    
@endsection

