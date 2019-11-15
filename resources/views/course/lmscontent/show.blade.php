@extends('layouts.app')
@section('title',$content->title)
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
    <link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>{{$content->title}}</span>
        </h3>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="template-demo">
                        <form id="editable-form" class="editable-form">
                            <div class="form-group row">
                                <label class="col-6 col-lg-4 col-form-label">@lang('form.code_module')</label>
                                <div class="col-6 col-lg-8 d-flex align-items-center">
                                    <a href="#"  class="editable editable-click" style="">{{$content->code}}</a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-6 col-lg-4 col-form-label">@lang('profile.status')</label>
                                <div class="col-6 col-lg-8 d-flex align-items-center">
                                    <a href="#"  class="editable " style="">
                                    @if($content->isActive())
                                            <span class="badge badge-success">@lang('form.active')</span>
                                        @else
                                            <span class="badge badge-secondary">@lang('form.disabled')</span>
                                    @endif
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-6 col-lg-4 col-form-label">{{ucfirst(trans('form.course'))}}</label>
                                <div class="col-6 col-lg-8 d-flex align-items-center">
                                    <a href="#" class="editable editable-click editable-empty" >{{@$content->module->course->name}}</a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-6 col-lg-4 col-form-label">{{ucfirst(trans('form.module'))}}</label>
                                <div class="col-6 col-lg-8 d-flex align-items-center">
                                    <a href="#"  class="editable editable-click" style="">{{@$content->module->module_name}}</a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-6 col-lg-4 col-form-label">@lang('form.description')</label>
                                <div class="col-6 col-lg-8 d-flex align-items-center">
                                   {!! $content->description !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-6 col-lg-4 col-form-label">@lang('form.content_type')</label>
                                <div class="col-6 col-lg-8 d-flex align-items-center">
                                    <a href="#" class="editable editable-click" style="">{{ucwords(str_replace('_',' ', $content->content_type))}}</a>
                                </div>
                            </div>
                            @if($content->is_url)
                                <div class="form-group row">
                                    <label class="col-6 col-lg-4 col-form-label">@lang('form.resource_link')</label>
                                    <div class="col-6 col-lg-8 d-flex align-items-center">
                                        <a target="_blank" href="{{$content->file_path}}" class="editable editable-click" style="">{{$content->file_path}}</a>
                                    </div>
                                </div>
                            @elseif($content->content_type !='text' && !$content->is_url)
                                <div class="form-group row">
                                    <label class="col-6 col-lg-4 col-form-label">@lang('form.lms_file')</label>
                                    <div class="col-6 col-lg-8 d-flex align-items-center">
                                        <a target="_blank" href="{{url($content->content_path.$content->file_path)}}" class="editable editable-click" style="">{{url($content->content_path.$content->file_path)}}</a>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-6 col-lg-4 col-form-label">@lang('form.created')</label>
                                <div class="col-6 col-lg-8 d-flex align-items-center">
                                    <a  href="#" class="editable editable-click" style="">{{diffForHumans($content->created_at)}}</a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-6 col-lg-4 col-form-label">@lang('form.created_by')</label>
                                <div class="col-6 col-lg-8 d-flex align-items-center">
                                    <a  href="#" class="editable editable-click" style="">{{$content->user->displayName()}}</a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-6 col-lg-4 col-form-label">@lang('form.updated_by')</label>
                                <div class="col-6 col-lg-8 d-flex align-items-center">
                                    <a  href="#" class="editable editable-click" style="">{{$content->updatedByUser->displayName()}}</a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-6 col-lg-4 col-form-label">@lang('form.locked_by')</label>
                                <div class="col-6 col-lg-8 d-flex align-items-center">
                                    <a  href="#" class="editable editable-click" style="">{{optional($content->lockedByUser)->displayName()}}</a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-6 col-lg-4 col-form-label">@lang('form.locked')</label>
                                <div class="col-6 col-lg-8 d-flex align-items-center">
                                    <a  href="#" class="editable editable-click" style="">{{diffForHumans($content->locked)}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

