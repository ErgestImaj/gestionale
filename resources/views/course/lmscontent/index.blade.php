@extends('layouts.app')
@section('title',trans('menu.lms_content'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
@endsection
@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('menu.lms_content')</span>

            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <div class="col-md-2">
                        <a href="{{route('lms-content.create')}}"  class="btn btn-primary">
                            <i class="fas fa-plus"></i> @lang('form.add_content')
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('form.code_module')</th>
                                    <th>{{ucfirst(trans('form.module'))}}</th>
                                    <th width="15%">@lang('form.code')</th>
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
    <script src="{{asset('js/lmscontent.js')}}"></script>
    <script src="{{asset('js/actions.js')}}"></script>
    <script src="{{asset('js/search.js')}}"></script>
@endpush
