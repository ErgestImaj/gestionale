@extends('layouts.app')
@section('title',trans('menu.mass_emails'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
    <link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
@endsection
@section('content')
    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('menu.mass_emails')</span>
            </h3>
        </div>
        <div class="card mb-5">
            <div class="card-body">
               <mass-emails></mass-emails>
            </div>
        </div>
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('messages.comm_histoy')</span>
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('form.subject')</th>
                                    <th>@lang('form.description')</th>
                                    <th>@lang('form.target')</th>
                                    <th>@lang('form.exclude')</th>
                                    <th>@lang('form.created')</th>
                                    <th>@lang('form.created_by')</th>
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
    <script>
        var actionUrl = '{{route('admin.apimassemail')}}';
    </script>
    <script src="{{asset('js/addons.js')}}"></script>
    <script src="{{asset('js/massemails.js')}}"></script>
    <script src="{{asset('js/actions.js')}}"></script>
    <script src="{{asset('js/search.js')}}"></script>

@endpush
