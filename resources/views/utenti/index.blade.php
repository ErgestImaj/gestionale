@extends('layouts.app')
@section('title', 'Utenti')
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
@endsection
@section('content')

	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i> Utenti</span>
		</h3>
	</div>
	<v-app>
	`<utenti-view user-type="{{$type ?? ''}}"></utenti-view>
	</v-app>
@endsection
