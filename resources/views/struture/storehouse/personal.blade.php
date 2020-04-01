@extends('layouts.app')
@section('title', 'Magazzino')
@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i>Magazzino</span>
		</h3>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						@foreach($courses as $course)
							<div class="col-xl-4">
								<div class="card card-default" style="border-top-color: lightskyblue">
									<div class="card-header">
										<div class="card-title">{{ $course->name ?? 'Course Cancellato'}}</div>
									</div>
									<div class="list-group-flush">
										<div class="list-group-item border-bottom">
											<div class="media">
												<div class="align-self-start mr-2">
                                            <span class="fa-stack">
                                                <em class="fa fa-circle fa-stack-2x text-info"></em>
                                                <em
																									class="fa fa-angle-double-down fa-stack-1x fa-inverse text-white"></em>
                                            </span>
												</div>
												<div class="media-body text-truncate">
													<p class="mt-1"><span
															class="text-info m-0">Acquistati</span>
													</p>
												</div>
												<div class="ml-auto">
                                            <span class="mt-2 ml-2 badge badge-info ">
                                              Quantità: {{ $course->purchased_qty}}
                                            </span>
												</div>
											</div>
										</div>
										<div class="list-group-item border-bottom">
											<div class="media">
												<div class="align-self-start mr-2">
                                            <span class="fa-stack">
                                                <em class="fa fa-circle fa-stack-2x text-info"></em>
                                                <em
																									class="fa fa-angle-double-up fa-stack-1x fa-inverse text-white"></em>
                                            </span>
												</div>
												<div class="media-body text-truncate">
													<p class="mt-1"><span
															class="text-info">Distribuiti</span>
													</p>
												</div>
												<div class="ml-auto">
                                            <span class="mt-2 ml-2 badge badge-info">
                                                Quantità: {{ $course->distributed_qty}}
                                            </span>
												</div>
											</div>
										</div>
{{--						APLY ONLY FOR STRUCTURE VIEW				@hasanyrole('partner|master')--}}
										<div class="list-group-item border-bottom">
											<div class="media">
												<div class="align-self-start mr-2">
                                            <span class="fa-stack">
                                                <em class="fa fa-circle fa-stack-2x text-info"></em>
                                                <em
																									class="fa fa-angle-double-up fa-stack-1x fa-inverse text-white"></em>
                                            </span>
												</div>
												<div class="media-body text-truncate">
													<p class="mt-1"><span
															class="text-info">Assegnati</span>
													</p>
												</div>
												<div class="ml-auto">
                                            <span class="mt-2 ml-2 badge badge-info">
                                                Quantità: {{  $course->assigned_qty}}
                                            </span>
												</div>
											</div>
										</div>
{{--										@endhasanyrole--}}
										<div class="list-group-item border-bottom">
											<div class="media">
												<div class="align-self-start mr-2">
                                            <span class="fa-stack">
                                                <em class="fa fa-circle fa-stack-2x text-info"></em>
                                                <em class="fa fa-inbox fa-stack-1x fa-inverse text-white"></em>
                                            </span>
												</div>
												<div class="media-body text-truncate">
													<p class="mt-1"><span
															class="text-info m-0">Disponibili</span>
													</p>
												</div>
												<div class="ml-auto">
                                            <span
																							class="mt-2 ml-2 badge badge-{{ $course->available_qty > 0 ? 'success' : 'warning' }} ">
                                                 Quantità: {{ $course->available_qty}}
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

