@extends('layouts.app')
@section('title',trans('form.edit_file'))
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>@lang('form.edit_file')</span>
        </h3>
    </div>
		<v-app>
			<v-card
				outlined
				flat
			>
				<document-edit></document-edit>
			</v-card>
		</v-app>
@endsection

