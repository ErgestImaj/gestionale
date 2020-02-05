@extends('layouts.app')
@section('title',trans('form.edit_file'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
    <link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>@lang('form.edit_file')</span>
        </h3>
    </div>
		<v-app>
			<v-card
				outlined
				flat
			>
				<document-edit></document-edit>
			</v-card>

		</v-app>
@endsection
@push('scripts')
    <script src="{{asset('js/actions.js')}}"></script>
@endpush
