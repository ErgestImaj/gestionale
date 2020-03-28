@extends('layouts.app')
@section('title', 'Elenco Ordini')

@section('content')

	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i> Elenco Ordini</span>
		</h3>
	</div>
	<v-app>
		<elenco-ordini></elenco-ordini>
	</v-app>
@endsection

@push('scripts')
	<script src="{{asset('js/actions.js')}}"></script>
@endpush
