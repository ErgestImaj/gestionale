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
											<div class="form-check form-check-flat form-check-primary">
                           <form method="POST"  action="{{route('general.invoice.store')}}">
                                 @csrf
														 <div class="pl-lg-4">
														 <div class="row">
															 @foreach($fileds as $field)
															 <div class="col-lg-12">
																 <div class="form-group mb-0">
																	 <label class="form-control-label d-block" for="{{$field}}">{{ucwords(str_replace('_',' ',$field))}}</label>
																	 <input type="text" name="{{$field}}" id="{{$field}}" class="form-control @error($field) is-invalid @enderror"  value="{{ auth()->user()->electroniceInvoiceSettings->$field ?? old($field) }}">
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

    </div>
@endsection

