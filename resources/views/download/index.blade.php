@extends('layouts.app')
@section('title',trans('form.doc_list'))
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>@lang('form.doc_list')</span>
        </h3>
    </div>
    <v-app>
        <document-list></document-list>
    </v-app>
@endsection
@push('scripts')
    <script src="{{asset('js/actions.js')}}"></script>
@endpush
