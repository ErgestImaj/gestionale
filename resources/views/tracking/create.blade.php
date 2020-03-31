@extends('layouts.app')
@section('title', 'Nuova spedizione')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Nuova spedizione</span>
        </h3>
    </div>
		<v-app>
			<tracking-create></tracking-create>
		</v-app>
@endsection
