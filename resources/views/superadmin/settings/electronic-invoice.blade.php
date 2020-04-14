@extends('layouts.app')
@section('title','Scadenza contratto ')
@section('content')
    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>Dati Fattura Elettronica</span>
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
											<div class="accordion" id="accordion" role="tablist">
												@foreach($settings as $setting)
												<div class="card">
													<div class="card-header" role="tab" id="heading-{{$setting->id}}">
														<h6 class="mb-0">
															<a data-toggle="collapse" href="#collapse-{{$setting->id}}" aria-expanded="false" aria-controls="collapse-{{$setting->id}}">
														   Fatture: @if ($setting->type == \App\Models\ElectronicInvoiceSettings::MEDIAFORM) MEDIAFORM
																@elseif($setting->type == \App\Models\ElectronicInvoiceSettings::LRN) LRN
																@elseif($setting->type == \App\Models\ElectronicInvoiceSettings::DILE) DILE
																@elseif($setting->type == \App\Models\ElectronicInvoiceSettings::MIUR) MIUR
																@else($setting == \App\Models\ElectronicInvoiceSettings::IIQ) IIQ
																@endif
															</a>
														</h6>
													</div>
													<div id="collapse-{{$setting->id}}" class="collapse"
															 role="tabpanel" aria-labelledby="heading-{{$setting->id}}" data-parent="#accordion">
														<div class="card-body">
															<div class="row">
																<div class="col-md-12">
																		<form method="POST"  action="{{route('superadmin.invoice.update',$setting->id)}}">
																			@csrf
																			@method('PATCH')
																			<div class="pl-lg-4">
																				<div class="row">
																					@foreach($fileds as $field)
																						<div class="col-lg-12">
																							<div class="form-group mb-0">
																								<label class="form-control-label d-block" for="{{$field}}">{{ucwords(str_replace('_',' ',$field))}}</label>
																								<input type="text" name="{{$field}}" id="{{$field}}" class="form-control @error($field) is-invalid @enderror"  value="{{ $setting[$field] ?? old($field) }}">
																								@error($field)
																								<span class="invalid-feedback" role="alert">
                                                                     <strong>{{ $message }}</strong>
                                                                </span>
																								@enderror
																							</div>
																						</div>
																					@endforeach
																				</div>
																				<button type="submit" class="btn btn-info">{{trans('form.save')}}</button>
																			</div>
																		</form>
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

    </div>
@endsection

