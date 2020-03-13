@extends('layouts.app')
@section('title',trans('form.add_file'))
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>@lang('form.add_file')</span>
        </h3>
    </div>
		<v-app>
			<v-card
				outlined
				flat
			>
				<document-create></document-create>
			</v-card>

		</v-app>
@endsection
