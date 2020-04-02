@extends('layouts.app')
@section('title', 'Ordini Fast Track')

@section('content')

	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i> Elenco Ordini Fast Track</span>
		</h3>
	</div>
	<v-app>
		<ordini-fast-track></ordini-fast-track>
	</v-app>
@endsection

