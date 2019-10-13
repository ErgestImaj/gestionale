@extends('layouts.app')
@section('title',trans('menu.permission'))

@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>{{trans('menu.permission')}}</span>

            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <div class="col-md-12">
                        <div class="alert alert-info text-" role="alert">
                         {{trans('messages.maintenance')}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

                        <div class="form-check form-check-flat form-check-primary">
                           <form method="POST" action="{{route('superadmin.maintenance.update')}}">
                                    @csrf
                                    @method('PATCH')
                               <label class="form-check-label">
                                <input name="status" onclick="this.form.submit()" type="checkbox" {{ $mode ? 'checked' : '' }} class="form-check-input">
                               <i class="input-helper"></i>
                                   {{trans('menu.maintenance')}}
                               </label>
                                </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

