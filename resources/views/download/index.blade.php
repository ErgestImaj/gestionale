@extends('layouts.app')
@section('title',trans('menu.documents'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
@endsection
@section('content')

    <div class="content-single">
        <div class="row">
					<div class="col-md-6 mb-3">
						<div class="page-header">
							<h3 class="page-title">
								<span class="text-semibold"><i class="fas fa-list"></i>@lang('menu.documents')</span>
							</h3>
						</div>
					</div>
            <div class="col-md-6 mb-3" style="text-align: right">
							<div class="pb-2">
								<a href="{{route('admin.download.create')}}"  class="btn btn-primary">
									<i class="fas fa-plus"></i> @lang('form.add_file')
								</a>
							</div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="document-list" class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('form.name')</th>
                                    <th>{{ucfirst(trans('form.category'))}}</th>
                                    <th>@lang('form.created_by')</th>
                                    <th>@lang('form.updated_by')</th>
                                    <th>@lang('form.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/addons.js')}}"></script>
    <script src="{{asset('js/download.js')}}"></script>
    <script src="{{asset('js/actions.js')}}"></script>
    <script src="{{asset('js/search.js')}}"></script>
@endpush
