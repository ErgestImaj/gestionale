@extends('layouts.app')
@section('title',trans('form.doc_cat'))
@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i>@lang('form.doc_cat')</span>
		</h3>
	</div>
	<v-app>
			<document-categories></document-categories>
	</v-app>
@endsection
@push('scripts')
	<script src="{{asset('js/actions.js')}}"></script>
@endpush
