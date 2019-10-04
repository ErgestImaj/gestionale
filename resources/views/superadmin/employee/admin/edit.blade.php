@extends('layouts.app')
@section('title','Profile')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Edit User: {{$user->full_name}}</span>
        </h3>
    </div>
    <div class="row">

        @include('superadmin.employee.__partial_profile_right')

        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('update',['user'=>$user->hashid()])}}" enctype="multipart/form-data" method="POST">
                        @method('PATCH')
                        @csrf
                        @include('superadmin.employee.__partial_form')
                        <hr class="my-4">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
