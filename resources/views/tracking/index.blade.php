@extends('layouts.app')
@section('title', 'Tracking')

@section('content')

	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i> Tracking</span>
		</h3>
	</div>
	<v-app>
		<tracking-list create-url="{{route('tracking.create')}}"></tracking-list>
	</v-app>
@endsection

@push('scripts')
	<script src="{{asset('js/actions.js')}}"></script>
@endpush
