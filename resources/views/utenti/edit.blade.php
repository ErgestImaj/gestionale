@extends('layouts.app')
@section('title', 'Modifica Utente')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Modifica Utente</span>
        </h3>
    </div>
		<v-app>
						@if (
							$type == User::$roles[User::ADMIN] ||
							$type == User::$roles[User::SEGRETERIA] ||
							$type == User::$roles[User::TUTOR] ||
							$type == User::$roles[User::AREA_LRN] ||
							$type == User::$roles[User::AREA_DILE]
							)
                <utenti-basic-edit user-type="{{$type}}"></utenti-basic-edit>
            @else
                <utenti-edit user-type="{{$type ?? ''}}"></utenti-edit>
            @endif
        </v-app>
@endsection
