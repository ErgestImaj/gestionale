@extends('layouts.app')
@section('title','Scadenza contratto ')
@section('content')
    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>Scadenza contratto </span>
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-0">
                    <div class="col-md-12 mb-0">
                        <p class="card-description">Scegli il periodo di scadenza dei contrati per i centri nel gestionale</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                           <form method="POST" class="form-inline"  action="{{route('superadmin.scadenza_contrato.add')}}">
                                    @csrf
														 <select class="custom-select my-1 mr-sm-2" name="period" id="inlineFormCustomSelectPref">
															 <option value="1" @if($period == 1) selected  @endif>12 mesi</option>
															 <option value="2" @if($period == 2) selected  @endif>24 mesi</option>
														 </select>
                               <button type="submit" class="btn btn-info">{{trans('form.save')}}</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

