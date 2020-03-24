@extends('layouts.app')
@section('title',trans('menu.course'))
@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('headers.courses_list')</span>

            </h3>
        </div>
				<v-app>
					<corsi-table></corsi-table>
				</v-app>

    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/actions.js')}}"></script>
@endpush
