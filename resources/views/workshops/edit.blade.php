@extends('layouts.app')
@section('title',trans('menu.workshop'))
@section('content')
    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>@lang('menu.workshop')</span>
            </h3>
        </div>

        <v-app class="workshop">
            <workshop-edit note="{!! e($workshop->note) !!}"></workshop-edit>
        </v-app>

    </div>
@endsection

