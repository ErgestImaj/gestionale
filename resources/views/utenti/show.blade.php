@extends('layouts.app')
@section('title', 'Dettagli Utente')
@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i>{{$user_details['display_name']}}</span>
		</h3>
	</div>
	<v-app>
		<user-details
			base_info="{!! e(json_encode($base_info),true)!!}"
			user_details="{!! e(json_encode($user_details),true)!!}"
			personal_info="{!! e(json_encode($personal_info),true)!!}"
			address_info="{!! e(json_encode($address_info),true)!!}"
			education="{!! e(json_encode($education),true)!!}"
			other_info="{!! e(json_encode($other_info),true)!!}"
		>
		</user-details>
	</v-app>
@endsection

