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
				:is-edit="{{true}}"
				:edit-content="{!! e(json_encode([$lms_content, $lms_content->module->course->hashid]),true) !!}"
		 	>
			</add-lms>
		</v-app>

@endsection

