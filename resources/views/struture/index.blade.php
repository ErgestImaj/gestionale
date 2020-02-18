@extends('layouts.app')
@section('title','Struture')
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
@endsection
@section('content')

	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i>Struture</span>
		</h3>
	</div>
	<v-app>
		<structure-view structure-type="{{$type}}"></structure-view>
	</v-app>
@endsection
