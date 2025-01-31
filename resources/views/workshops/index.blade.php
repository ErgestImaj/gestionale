@extends('layouts.app')
@section('title',trans('menu.workshop'))
@section('content')
    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('menu.workshop_data')</span>
            </h3>
        </div>
        <v-app class="workshop">
            <workshop></workshop>
        </v-app>

    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/actions.js')}}"></script>
@endpush
