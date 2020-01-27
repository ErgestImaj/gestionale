@extends('layouts.app')
@section('title',trans('menu.documents'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
@endsection
@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('menu.documents')</span>
            </h3>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body  p-2">
                        <div class="card-title">
                            <div class="col-md-12">
                                <p class="card-description">@lang('headers.filter')</p>
                            </div>
                        </div>
                        <div id="filter-category" class="pb-2">
                            <select class="form-control">
                                <option value="">@lang('headers.all')</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body  p-2">
                        <div class="card-title">
                            <div class="col-md-12">
                                <p class="card-description">@lang('form.actions')</p>
                            </div>
                        </div>
                        <div class="pb-2">
                            <a href="#"  class="btn btn-primary">
                                <i class="fas fa-plus"></i> @lang('form.add_course')
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="document-list" class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('form.code')</th>
                                    <th>{{ucfirst(trans('form.category'))}}</th>
                                    <th width="15%">@lang('form.name')</th>
                                    <th>@lang('form.costo')</th>
                                    <th>@lang('profile.status')</th>
                                    <th>@lang('form.created_by')</th>
                                    <th>@lang('form.updated_by')</th>
                                    <th>@lang('form.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/addons.js')}}"></script>
    <script src="{{asset('js/download.js')}}"></script>
    <script src="{{asset('js/actions.js')}}"></script>
    <script src="{{asset('js/search.js')}}"></script>
@endpush
