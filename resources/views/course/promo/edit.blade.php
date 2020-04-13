@extends('layouts.app')
@section('title','Gestione Promo Pack')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Gestione Promo Pack</span>
        </h3>
    </div>
		<v-app>
			<promo-create :is-edit="true" :data="{{$promo}}"></promo-create>
		</v-app>
@endsection
