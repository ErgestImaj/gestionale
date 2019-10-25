@extends('layouts.app')
@section('title',trans('menu.category'))

@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>{{trans('menu.category')}}</span>
            </h3>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="col-md-12">
                               <p class="card-description">{{trans('headers.new_category')}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <form action="@if(isset($category)) {{route('admin.category.update',['category'=>$category->hashid()])}}@else{{route('admin.category.new')}}@endif" method="POST">
                                  @csrf
                                    @if(isset($category))
                                        @method('PATCH')
                                    @endif

                                    <div class="form-group">
                                        <label class="form-control-label" for="category-name">{{trans('form.category_name')}}</label>
                                        <input type="text" name="name" id="category-name" class="form-control @error('name') is-invalid @enderror" placeholder="{{trans('form.category_name')}}" value="{{$category->name ?? old('name') }}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                         </span>
                                        @enderror
                                    </div>
                                   <button class="btn-info btn" type="submit ">{{trans('form.save')}}</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                        <thead>
                                        <tr>
                                            <th>{{trans('form.name')}}</th>
                                            <th>{{trans('form.created_by')}}</th>
                                            <th>{{trans('form.updated_by')}}</th>
                                            <th>{{trans('form.actions')}}</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($categories as $category)
                                            <tr>
                                                <td>{{$category->name}}</td>
                                                <td>{{optional($category->user)->displayName()}}</td>
                                                <td>{{optional($category->updatedByUser)->displayName()}}</td>
                                                <td>
                                                    <a class="btn block-btn btn-dark mb-1"  data-tooltip="{{trans('form.edit')}}" href="{{route('admin.category.edit',['category'=>$category->hashid()])}}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a class="btn block-btn delete-btn btn-danger mb-1" data-action="{{route('admin.category.destroy',['category'=>$category->hashid()])}}"  data-content="{{trans('messages.delete_confirm_pl',['record'=>strtolower(trans('form.category'))])}}"  data-tooltip="{{trans('form.delete')}}" href="#">
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
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/actions.js')}}"></script>
@endpush
