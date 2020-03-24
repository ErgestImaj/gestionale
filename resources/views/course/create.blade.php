@extends('layouts.app')
@section('title',trans('form.add_course'))
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>@lang('form.add_course')</span>
        </h3>
    </div>
		<v-app>
			<add-course
				:categories="{{$categories}}"
				:expirations="{{$expirations}}"
				:vatrates="{{$vatrates}}"
			></add-course>
		</v-app>
@endsection
