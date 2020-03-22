@extends('layouts.app')
@section('title',trans('menu.lms_content'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
@endsection
@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('menu.lms_content')</span>

            </h3>
        </div>

				<v-app>
					<list-lms></list-lms>
				</v-app>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/addons.js')}}"></script>
    <script src="{{asset('js/lmscontent.js')}}"></script>
    <script src="{{asset('js/actions.js')}}"></script>
    <script src="{{asset('js/search.js')}}"></script>
@endpush
