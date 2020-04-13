@extends('layouts.app')
@section('title', 'Nuova Sessione d\'esame')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Nuova Sessione d'esame</span>
        </h3>
    </div>
		<v-app>
			<mediaform-create
				type="2"
			></mediaform-create>
		</v-app>
@endsection
