@extends('layouts.app')
@section('title',trans('form.add_module'))
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="text-semibold"><i class="fas fa-list"></i>@lang('form.add_module')</span>
        </h3>
    </div>
		<v-app>
			<module-list></module-list>
		</v-app>
@endsection
@push('scripts')
    <script src="{{asset('js/actions.js')}}"></script>
@endpush
