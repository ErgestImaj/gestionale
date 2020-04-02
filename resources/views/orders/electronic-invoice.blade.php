@extends('layouts.app')
@section('title', 'Fattura Elettronica')

@section('content')

	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i>Fattura Elettronica</span>
		</h3>
	</div>
	<v-app>
		<electronic-invoice></electronic-invoice>
	</v-app>
@endsection

