@extends('layouts.app')
@section('title', 'Nuovo Sconto')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
        <span class="text-semibold"><i class="fas fa-list"></i>Nuovo Sconto - #{{$id}}</span>
        </h3>
    </div>
		<v-app>
            <add-discount stucture-id='{{$id}}'></add-discount>
		</v-app>
@endsection
