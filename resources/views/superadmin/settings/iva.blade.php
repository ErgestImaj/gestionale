@extends('layouts.app')
@section('title',trans('menu.iva'))
@section('content')
    @include('superadmin.settings.edit_iva_modal')
    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>{{trans('menu.iva')}}</span>
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <div class="col-md-12">
                        <p class="card-description">{{trans('form.add')}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                           <form method="POST" class="form-inline"  action="{{route('superadmin.iva.add')}}">
                                    @csrf
                               <label class="sr-only" for="vat_name">{{trans('form.name')}}</label>
                               <input type="text" name="vat_name" class="form-control mb-2 mr-sm-2 @error('vat_name') is-invalid @enderror" id="vat_name" placeholder="{{trans('form.name')}}" >

                               <label class="sr-only" for="vat_value">{{trans('form.value')}}</label>
                               <div class="input-group mb-2 mr-sm-2">
                                   <div class="input-group-prepend">
                                       <div class="input-group-text">0.00</div>
                                   </div>
                                   <input type="text" name="vat_value" class="form-control  @error('vat_value') is-invalid @enderror" id="vat_value" placeholder="{{trans('form.value')}}">
                               </div>
                               <button type="submit" class="btn btn-primary mb-2">{{trans('form.add')}}</button>

                            </form>
                        <div class="row">
                            <div class="col-md-4 col-lg-2 col-sm-12">
                                @error('vat_name')
                                <span class="d-block invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                          </span>
                                @enderror
                            </div>
                            <div class="col-md-5 col-lg-2 col-sm-12">
                                @error('vat_value')
                                <span class="d-block invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                           </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{trans('form.name')}}</th>
                                    <th>{{trans('form.value')}}</th>
                                    <th>{{trans('form.actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vats as $vat)
                                <tr class="data-row">
                                    <td class="vat-name">{{$vat->name}}</td>
                                    <td class="vat-value">@convert_to_percent($vat->value)</td>
                                    <td>
                                        <a class="btn block-btn btn-dark mb-1" data-action="{{route('superadmin.iva.update',['rate'=>$vat->hashid()])}}" data-toggle="modal" data-target="#editModal" data-tooltip="{{trans('form.edit')}}" href="#">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a class="btn block-btn delete-btn btn-danger mb-1" data-action="{{route('superadmin.iva.destroy',['rate'=>$vat->hashid()])}}"  data-content="{{trans('messages.delete_confirm',['record'=>trans('menu.iva')])}}"  data-tooltip="{{trans('form.delete')}}" href="#">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
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
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var el = $(event.relatedTarget) // Button that triggered the modal
            var route = el.data('action');
            var modal = $(this);
            modal.find('#editform').attr('action', route);
            var row = el.closest(".data-row");
            modal.find('#vat-name').val(row.children(".vat-name").text())
            modal.find('#vat-value').val(row.children(".vat-value").text().replace('%',''))
        })
    </script>
    <script src="{{asset('js/actions.js')}}"></script>
@endpush
