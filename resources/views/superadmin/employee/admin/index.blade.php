@extends('layouts.app')
@section('title',trans('menu.admin'))

@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
    <link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
@endsection
@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>{{trans('headers.admin_users')}}</span>

            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <div class="col-md-2">
                        <a href="{{route('superadmin.admins.create')}}"  class="btn btn-primary">
                            <i class="fas fa-plus"></i> {{trans('form.new_record',['record'=>trans('menu.user')])}}
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
                                    <th>{{trans('form.username')}}</th>
                                    <th>{{trans('form.name')}}</th>
                                    <th>{{trans('form.last_name')}}</th>
                                    <th>Email</th>
                                    <th>{{trans('profile.status')}}</th>
                                    <th>{{trans('profile.last_login')}}</th>
                                    <th>{{trans('form.created')}}</th>
                                    <th>{{trans('form.actions')}}</th>
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
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/summernote-bs4.min.js')}}"></script>
@endpush
