@extends('layouts.app')
@section('title', 'Nuova Sessione d\'esame')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Nuova Sessione d'esame</span>
        </h3>
    </div>
		<v-app>
			<sessione-essame-create></sessione-essame-create>
		</v-app>
@endsection
