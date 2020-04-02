@extends('layouts.app')
@section('title', 'Richieste corsi')

@section('content')

	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i>Richieste corsi</span>
		</h3>
	</div>
	<v-app>
		<ordini-structure></ordini-structure>
	</v-app>
@endsection

