@extends('layouts.app')
@section('title', 'Modifica spedizione')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Modifica spedizione</span>
        </h3>
    </div>
		<v-app>
			<tracking-edit></tracking-edit>
		</v-app>
@endsection
