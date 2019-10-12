@extends('layouts.app')
@section('title','Profile')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i> {{trans('form.new_record',['record'=>trans('menu.user')])}}</span>
        </h3>
    </div>
    <div class="row">
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('superadmin.admins.store')}}" enctype="multipart/form-data" method="POST">
                        @csrf
                         @include('superadmin.employee.__partial_form')
                        <hr class="my-4">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
