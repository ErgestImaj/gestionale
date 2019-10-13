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
                         {{trans('messages.permission')}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{trans('form.name')}}</th>
                                    <th>{{trans('profile.status')}}</th>
                                    <th>{{trans('form.locked')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($usergroups as $group)
                                    @if($group->name == \App\Models\User::SUPERADMIN) @continue @endif
                                <tr>
                                    <td>
                                        {{ucwords($group->name)}}
                                        <label class="badge badge-warning badge-pill">{{$group->usersCount}} {{ trans_choice('messages.users', $group->usersCount) }}</label>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-flat form-check-primary">
                                           <form method="POST" action="{{route('superadmin.permission.update',['userGroups'=>$group->hashid()])}}">
                                                    @csrf
                                                    @method('PATCH')
                                               <label class="form-check-label">
                                                <input name="status" onclick="this.form.submit()" type="checkbox" {{ $group->state ? 'checked' : '' }} class="form-check-input">
                                               <i class="input-helper"></i>
                                               </label>
                                                </form>
                                        </div>
                                    </td>
                                    <td>
                                        {{format_date($group->locked)}}
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

