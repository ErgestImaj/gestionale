@extends('layouts.app')
@section('title', 'Report formazione')

@section('content')

	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i> Report formazione</span>
		</h3>
	</div>
	<v-app>
		<certificate-list></certificate-list>
	</v-app>
@endsection

@push('scripts')
	<script src="{{asset('js/actions.js')}}"></script>
@endpush
