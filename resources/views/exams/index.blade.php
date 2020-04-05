@extends('layouts.app')
@section('title', 'Exams')
@section('content')
	<div class="content-single">
		<div class="page-header">
			<h3 class="page-title">
				<span class="text-semibold"><i class="fas fa-list"></i> Exams</span>
			</h3>
		</div>
		<v-app class="exams">
			<sessione-essame-list
				:category="'lrn'"
				create-url="{{route('exams.lrn.create')}}"
			></sessione-essame-list>
		</v-app>

	</div>
@endsection
@push('scripts')
	<script src="{{asset('js/actions.js')}}"></script>
@endpush
