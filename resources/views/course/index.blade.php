@extends('layouts.app')
@section('title',trans('menu.course'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
@endsection
@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('headers.courses_list')</span>

            </h3>
        </div>
				<v-app>
					<corsi-table></corsi-table>
				</v-app>

    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/addons.js')}}"></script>
    <script src="{{asset('js/course.js')}}"></script>
    <script src="{{asset('js/actions.js')}}"></script>
    <script src="{{asset('js/search.js')}}"></script>
@endpush
