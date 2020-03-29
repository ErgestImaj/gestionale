@extends('layouts.app')
@section('title','Modifica Corso')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Modifica Corso</span>
        </h3>
    </div>
		<v-app>
			<add-course
				:categories="{{$categories}}"
				:expirations="{{$expirations}}"
				:vatrates="{{$vatrates}}"
				:old-course="{{$course}}"
				:settings="{{json_encode($settings)}}"
			></add-course>
		</v-app>
@endsection

