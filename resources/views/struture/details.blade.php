@extends('layouts.app')
@section('title', 'View')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
        <span class="text-semibold"><i class="fas fa-list"></i>{{$structure->name}}</span>
        </h3>
    </div>
		<v-app>
            <structure-details structure='{{$structure->hashid}}'></structure-details>
		</v-app>
@endsection
