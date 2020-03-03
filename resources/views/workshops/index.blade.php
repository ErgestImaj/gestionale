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
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('menu.workshop_data')</span>
            </h3>
        </div>
        <div class="card mb-5">
            <div class="card-body">
                <v-app class="workshop">
                    <workshop></workshop>
                </v-app>
            </div>
        </div>
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('messages.list_workshops')</span>
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
                                    <th>@lang('form.data')</th>
                                    <th>@lang('form.description')</th>
                                    <th>@lang('form.participants')</th>
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
    <script>
        var actionUrl = '{{route('admin.workshop.data')}}';
    </script>
    <script src="{{asset('js/addons.js')}}"></script>
   <script src="{{asset('js/workshop.js')}}"></script>
    <script src="{{asset('js/actions.js')}}"></script>
    <script src="{{asset('js/search.js')}}"></script>

@endpush
