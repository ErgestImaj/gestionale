@extends('layouts.app')
@section('title',trans('menu.email_settings'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
@endsection
@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>{{trans('menu.email_settings')}}</span>

            </h3>
        </div>
        <div class="card">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="col-md-12">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-check form-check-flat form-check-primary">
                                    <form method="POST" action="{{route('superadmin.emails.update',['key'=>'utilities'])}}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="pl-lg-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="lrn_email">{{trans('form.lrn_email')}}</label>
                                                        <input type="text" name="lrn_email" id="lrn_email" class="tags form-control @error('lrn_email') is-invalid @enderror"  value="{{ $config['lrn_email'] ?? '' }}">
                                                        @error('lrn_email')
                                                        <span class="invalid-feedback" role="alert">
                                                     <strong>{{ $message }}</strong>
                                                </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="lrn_email_cc">{{trans('form.lrn_email_cc')}}</label>
                                                        <input type="text" name="lrn_email_cc" id="lrn_email_cc" class="tags form-control @error('lrn_email_cc') is-invalid @enderror"  value="{{@$config['lrn_email_cc'] ?? '' }}">
                                                        @error('lrn_email_cc')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="support_email">{{trans('form.support_email')}}</label>
                                                        <input type="text" name="support_email" id="support_email" class="tags form-control @error('support_email') is-invalid @enderror" value="{{@$config['support_email'] ?? ''}}">
                                                        @error('support_email')
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                        @enderror

                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <button class="btn-info btn" type="submit ">{{trans('form.save')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="col-md-12">
                                <p class="card-description">{{trans('headers.email_smtp')}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-check form-check-flat form-check-primary">
                                    <form method="POST" action="{{route('superadmin.emailsmtp.update')}}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="pl-lg-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="mail_host">{{trans('form.mail_host')}}</label>
                                                        <input type="text" name="mail_host" id="mail_host" class="form-control @error('mail_host') is-invalid @enderror"  value="{{ $host  }}">
                                                        @error('mail_host')
                                                            <span class="invalid-feedback" role="alert">
                                                               <strong>{{ $message }}</strong>
                                                           </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="mail_port">{{trans('form.mail_port')}}</label>
                                                        <input type="text" name="mail_port" id="mail_port" class="form-control @error('mail_port') is-invalid @enderror"  value="{{$port  }}">
                                                        @error('mail_port')
                                                        <span class="invalid-feedback" role="alert">
                                                              <strong>{{ $message }}</strong>
                                                          </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="username">{{trans('form.username')}}</label>
                                                        <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{$username ?? ''}}">
                                                        @error('username')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                           </span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="password">{{trans('form.password')}}</label>
                                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{$password ?? ''}}">
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                           </span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="email_address">{{trans('form.email_address_from')}}</label>
                                                        <input type="text" name="email_address" id="email_address" class="form-control @error('email_address') is-invalid @enderror" value="{{$address }}">
                                                        @error('email_address')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                           </span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="email_name">{{trans('form.email_name')}}</label>
                                                        <input type="text" name="email_name" id="email_name" class="form-control @error('email_name') is-invalid @enderror" value="{{$name ?? ''}}">
                                                        @error('email_name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                           </span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="encryption">{{trans('form.encryption')}}</label>
                                                        <input type="text" name="encryption" id="encryption" class="form-control @error('encryption') is-invalid @enderror" value="{{$encryption ?? ''}}">
                                                        @error('encryption')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                           </span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button class="btn-info btn" type="submit ">{{trans('form.save')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('js/addons.js')}}"></script>
    <script>
        $('.tags').tagsInput({
            'width': '100%',
            'height': '75%',
            'interactive': true,
            'defaultText': '{{trans('form.add')}}',
            'removeWithBackspace': true,
            'minChars': 0,
            'placeholderColor': '#666666'
        });
    </script>

@endpush
