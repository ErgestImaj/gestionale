@extends('layouts.app')
@section('title','Modifica Contenuto')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>Modifica Contenuto</span>
        </h3>
    </div>
		<v-app>
			<add-lms
				is-edit="{{true}}"
				prev-course="{{$lms_content->module->course->id}}"
				sel-module="{{$lms_content->module_id}}"
				edit-content="{!! e(json_encode($lms_content),true) !!}"
		 	>
			</add-lms>
		</v-app>

@endsection

