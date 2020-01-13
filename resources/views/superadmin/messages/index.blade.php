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
                <div class="row">
                    <div class="col-12">
                        <form action="{{route('admin.sendmassemail')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="subject">@lang('form.subject')</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" placeholder="@lang('form.subject')"
                                       name="subject" value="{{ old('subject') }}">
                                @error('subject')
                                <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="description">@lang('form.description')</label>
                                <textarea  name="description" id="description" class=" summernote form-control @error('description') is-invalid @enderror">{{old('description') }}</textarea>
                                @error('description')
                                <span class="invalid-feedback d-block" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-control-label"   for="target">@lang('form.target')</label>
                                <select class="form-control multiselect" multiple="multiple" name="target[]" id="target">
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}">{{ucwords($role->name)}}</option>
                                   @endforeach
                                </select>
                                @error('target')
                                <span class="invalid-feedback d-block" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="exclude">@lang('form.exclude')</label>
                                <select class="form-control multiselect" multiple="multiple" name="exclude[]" id="exclude">
                                    @foreach($emails as $email)
                                        <option value="{{$email->email}}">{{$email->email}}</option>
                                    @endforeach
                                </select>
                                @error('exclude')
                                <span class="invalid-feedback d-block" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">@lang('messages.send_email')</button>
                        </form>
                    </div>
                </div>
            </div>
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
    <script>
        jQuery(function ($) {
           $('.multiselect').select2({
               placeholder: "@lang('messages.select_an_option')",
           });
        })
    </script>
@endpush
