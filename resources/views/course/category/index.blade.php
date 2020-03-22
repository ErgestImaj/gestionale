@extends('layouts.app')
@section('title',trans('menu.category'))

@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>{{trans('menu.category')}}</span>
            </h3>
        </div>
				<v-app>
					<course-categories></course-categories>
				</v-app>
		</div>
@endsection
@push('scripts')
    <script src="{{asset('js/actions.js')}}"></script>
@endpush
