@extends('layouts.app')
@section('title',trans('form.add_course'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
    <link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>@lang('form.add_course')</span>
        </h3>
    </div>
    <form action="{{route('admin.courses.update',['course'=>$course->hashid()])}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        @include('superadmin.course._course_form')
    </form>
@endsection
@push('scripts')
    <script src="{{asset('js/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
@endpush
