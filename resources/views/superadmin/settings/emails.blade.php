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
            'maxChars': 20, // if not provided there is no limit
            'placeholderColor': '#666666'
        });
    </script>

@endpush
