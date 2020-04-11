@extends('layouts.app')
@section('title', 'Promo Pack')
@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i> Promo Pack</span>

            </h3>
        </div>
				<v-app>
					<promo-list create-url="{{route('admin.promo.pack.create')}}"></promo-list>
				</v-app>

    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/actions.js')}}"></script>
@endpush
