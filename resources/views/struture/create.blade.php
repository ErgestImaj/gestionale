@extends('layouts.app')
@section('title', 'Nuovo Strutura')
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
    <link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Nuova Strutura</span>
        </h3>
    </div>
		<v-app>
				<struture-create></struture-create>

		</v-app>
@endsection
