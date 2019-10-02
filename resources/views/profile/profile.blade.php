@extends('layouts.app')
@section('title','Profile')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Profile
        </h3>
    </div>
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-3">
            <div class="card card-profile">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image text-center">
                            <a href="#">
                                <img src="{{auth()->user()->avatar_url}}" class="img-lg rounded-circle my-3">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <h5 class="h3">{{$user->full_name}}</h5>
                </div>
                <div class="card-body pt-0">
                            <div>
                                <p class="clearfix">
                                    <span class="float-left">Username</span>
                                    <span class="float-right text-muted">{{$user->username}}</span>
                                </p>
                                 <p class="clearfix">
                                      <span class="float-left">Mail</span>
                                      <span class="float-right text-muted">{{$user->email}}</span>
                                 </p>
                                <p class="clearfix">
                                    <span class="float-left">Status</span>
                                    <span class="float-right text-muted">
                                       @if($user->state)
                                            <span class="badge badge-pill badge-success ml-auto px-1 py-1"><i class="fas fa-check font-weight-bold"></i></span>
                                           @else
                                            <span class="badge badge-pill badge-danger ml-auto px-1 py-1"><i class="fas fa-times font-weight-bold"></i></span>
                                        @endif
                                    </span>
                                </p>
                            </div>
                    </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('update',['user'=>$user->hashid()])}}" method="POST" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">First name</label>
                                        <input type="text" name="first_name" id="input-first-name" class="form-control @error('first_name') is-invalid @enderror"  placeholder="First name" value="{{$user->firstname}}">
                                        @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">Last name</label>
                                        <input type="text" name="last_name" id="input-last-name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last name" value="{{$user->lastname}}">
                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <input type="email" name="email" id="input-email" class="form-control @error('email') is-invalid @enderror" value="{{$user->email}}" placeholder="jesse@example.com">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-password">Password</label>
                                        <input type="password" name="password" id="input-password" class="form-control  @error('password') is-invalid @enderror">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Profile Image</label>
                                        <input type="file" name="image" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info @error('image') is-invalid @enderror" disabled placeholder="Upload Image">
                                            <span class="input-group-append">
                                              <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                            </span>
                                        </div>
                                        @error('image')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button class="btn-info btn" type="submit ">Salva</button>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
