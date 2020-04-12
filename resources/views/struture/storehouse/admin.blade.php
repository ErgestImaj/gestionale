@extends('layouts.app')
@section('title', 'Magazzino')
@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i>Magazzino</span>
		</h3>
		<a class="btn btn-vue" href="{{route('general.storehouse.export.index')}}">Esporta</a>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="gestcard">
				<div class="gest-body">
					<div class="row">
						@foreach($courses as $course)
							<div class="col-md-4">
								<div class="card card-default" style="border-top-color: lightskyblue">
									<div class="card-header">
										<div class="card-title">{{$course->name}}</div>
									</div>
									<div class="list-group-flush">
										<div class="list-group-item border-bottom">
											<div class="media">
												<div class="align-self-start mr-2">
													<span class="gicon">
														<em class="fa fa-angle-double-up"></em>
													</span>
												</div>
												<div class="media-body text-truncate">
													<p class="mt-1"><span class="text-info m-0">Acquistati</span></p>
												</div>

												<div class="ml-auto">
                        	<span class="badge badge-info">
                          	Quantità: {{$course->aquisti}}
                          </span>
												</div>
											</div>
										</div>
										<div class="list-group-item border-bottom">
											<div class="media">
												<div class="align-self-start mr-2">
													<span class="gicon">
														<em class="fa fa-eur"></em>
													</span>
												</div>
												<div class="media-body text-truncate">
													<p class="mt-1"><span class="text-info m-0">Totale</span></p>
												</div>

												<div class="ml-auto">
													<span class="badge badge-info ">{{$course->total}} </span>
												</div>
											</div>
										</div>

										<div class="list-group-item">
											<div class="media">
												<div class="align-self-start mr-2">
													<span class="gicon">
														<em class="fa fa-user"></em>
													</span>
												</div>
												<div class="media-body text-truncate">
													<p class="mt-1"><span class="text-info m-0">ADMIN</span></p>
												</div>
												<div class="ml-auto">
                        	<span class="badge badge-info ">
                          	{{$course->admin}}
                          </span>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

