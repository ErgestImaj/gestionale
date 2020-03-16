@extends('layouts.app')
@section('title', 'Nuovo Utente')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Nuovo Utente</span>
        </h3>
    </div>
		<v-app>
            @if ($type == User::$roles[User::ADMIN] || $type == User::$roles[User::SEGRETERIA] || $type == User::$roles[User::TUTOR] || $type == User::$roles[User::ISPETTORI])
                <utenti-basic-create user-type="{{$type}}"></utenti-basic-create>
            @else
                <utenti-create user-type="{{$type ?? ''}}"></utenti-create>
            @endif
        </v-app>
@endsection
