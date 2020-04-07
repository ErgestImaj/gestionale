@extends('layouts.app')
@section('title',trans('menu.mass_emails'))
@section('content')
    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('menu.mass_emails')</span>
            </h3>
        </div>
			<v-app>
               <mass-emails></mass-emails>
			</v-app>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/actions.js')}}"></script>
@endpush
