@extends('layouts.app')
@section('title', 'Magazzino - '.$structure_type)
@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="text-semibold"><i class="fas fa-list"></i>Magazzino - {{$structure_type}}</span>
		</h3>
	</div>

	 <div class="storehose">
		 <v-app>
			 <storehouse-export
				 type="{{$type ?? ''}}"
				 model="storehouse"
				 show="{{false}}"
			 >
			 </storehouse-export>
		 </v-app>
	 </div>

	<div class="row">
		<div class="col-12">
					<div class="row">
						@forelse ($structures as $structure)
								<div class="col-md-12">
											<div class="card card-default" style="border-top-color: lightskyblue">
												<div class="card-header">
													<div class="card-title">
														{{$structure_type}} - {{ $structure->legal_name }}
													</div>
												</div>
												<div class="card-body pl-0 pr-0 pt-0 mt-0">
													@if(count($structure->courses))
													<table class="table table-hover">
														<thead>
														<tr>
															<th>Corso</th>
															@if ($type != App\Models\Structure::TYPE_AFFILIATE)
															<th class="text-center">Acquistati</th>
															@endif
															@if ($type == App\Models\Structure::TYPE_MASTER || $type == App\Models\Structure::TYPE_PARTNER || $type == App\Models\Structure::TYPE_AFFILIATE)
															<th class="text-center">Assegnati</th>
															@endif
															<th class="text-center">Distribuiti</th>
															<th class="text-center">Disponibili</th>
															@hasanyrole('superadmin|admin')
															<th class="text-center">Amministrazione</th>
															@endhasanyrole
														</tr>
														</thead>
														<tbody>
																		@foreach($structure->courses as $course)
																			<tr>
																				<td class="td-coursename">{{$course->name}}</td>
																				@if ($type != App\Models\Structure::TYPE_AFFILIATE)
																				<td class="text-center {{$course->purchased_qty > 0 ? 'gnr' : ''}}">{{$course->purchased_qty}}</td>
																				@endif
																				@if ($type == App\Models\Structure::TYPE_MASTER || $type == App\Models\Structure::TYPE_PARTNER || $type == App\Models\Structure::TYPE_AFFILIATE)
																				<td class="text-center {{$course->assigned_qty > 0 ? 'gnr' : ''}}">{{$course->assigned_qty}}</td>
																				@endif
																				<td class="text-center {{$course->distributed_qty > 0 ? 'gnr' : ''}}">{{$course->distributed_qty}}</td>
																				<td class="text-center {{$course->available_qty > 0 ? 'gnr' : ''}}">{{$course->available_qty}}</td>
																				@hasanyrole('superadmin|admin')
																				<td class="text-center {{$course->admin_qty > 0 ? 'gnr' : ''}}">{{$course->admin_qty}}</td>
																				@endhasanyrole
																			</tr>

																		@endforeach
														</tbody>
													</table>
											@else
																		<div class="alert alert-info text-center mt-5">Nessun corso da visualizzare</div>
											@endif
												</div>
											</div>
								</div>
							@empty
								<div class="alert alert-info text-center">Nessun struttura da visualizzare</div>
						@endforelse
					</div>
		</div>
	</div>
@endsection

