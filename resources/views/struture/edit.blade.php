@extends('layouts.app')
@section('title', 'Modifica Strutura')
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
    <link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Modifica Strutura</span>
        </h3>
    </div>
		<v-app>
				<struture-edit></struture-edit>

		</v-app>
@endsection
