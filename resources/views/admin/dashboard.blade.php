@extends('layouts.admin')
@section('title')
{{__('Dashboard')}}
@endsection
@section('content')
    <div class="col-xs-6 col-lg-3">
        <a class="block block-link-hover1" href="{{ route('admin.users.index') }}">
            <div class="block-content block-content-full clearfix">
                <div class="pull-right push-15-t push-15">
                    <i class="fa fa-users fa-2x text-primary"></i>
                </div>
                <div class="h2 text-primary" data-toggle="countTo" data-to="{{ $users }}">{{ $users }}</div>
                <div class="text-uppercase font-w600 font-s12 text-muted">{{ trans_choice('dashboard.users', $users) }}</div>
            </div>
        </a>
    </div>
    
    <div class="col-xs-6 col-lg-3">
        <a class="block block-link-hover1" href="{{ route('admin.events.index') }}">
            <div class="block-content block-content-full clearfix">
                <div class="pull-right push-15-t push-15">
                    <i class="fa fa-calendar-alt fa-2x text-primary"></i>
                </div>
                <div class="h2 text-primary" data-toggle="countTo" data-to="{{ $events }}">{{ $events }}</div>
                <div class="text-uppercase font-w600 font-s12 text-muted">{{ trans_choice('dashboard.events', $events) }}</div>
            </div>
        </a>
    </div>

    <div class="col-xs-6 col-lg-3">
        <a class="block block-link-hover1" href="{{ route('admin.news.index') }}">
            <div class="block-content block-content-full clearfix">
                <div class="pull-right push-15-t push-15">
                    <i class="fa fa-newspaper fa-2x text-primary"></i>
                </div>
                <div class="h2 text-primary" data-toggle="countTo" data-to="{{ $news }}">{{ $news }}</div>
                <div class="text-uppercase font-w600 font-s12 text-muted">{{ trans_choice('dashboard.news', $news) }}</div>
            </div>
        </a>
    </div>

    <div class="col-xs-6 col-lg-3">
        <a class="block block-link-hover1" href="{{ route('admin.organizations.index') }}">
            <div class="block-content block-content-full clearfix">
                <div class="pull-right push-15-t push-15">
                    <i class="fas fa-building fa-2x text-primary"></i>
                </div>
                <div class="h2 text-primary" data-toggle="countTo" data-to="{{ $organizations }}">{{ $organizations }}</div>
                <div class="text-uppercase font-w600 font-s12 text-muted">{{ trans_choice('dashboard.organizations', $organizations) }}</div>
            </div>
        </a>
    </div>

    <div class="col-xs-6 col-lg-3">
        <a class="block block-link-hover1" href="{{ route('admin.projects.index') }}">
            <div class="block-content block-content-full clearfix">
                <div class="pull-right push-15-t push-15">
                    <i class="fas fa-forward fa-2x text-primary"></i>
                </div>
                <div class="h2 text-primary" data-toggle="countTo" data-to="{{ $projects }}">{{ $projects }}</div>
                <div class="text-uppercase font-w600 font-s12 text-muted">{{ trans_choice('dashboard.projects', $projects) }}</div>
            </div>
        </a>
    </div>

    <div class="col-xs-6 col-lg-3">
        <a class="block block-link-hover1" href="{{ route('admin.donators.index') }}">
            <div class="block-content block-content-full clearfix">
                <div class="pull-right push-15-t push-15">
                    <i class="fas fa-handshake fa-2x text-primary"></i>
                </div>
                <div class="h2 text-primary" data-toggle="countTo" data-to="{{ $donators }}">{{ $donators }}</div>
                <div class="text-uppercase font-w600 font-s12 text-muted">{{ trans_choice('dashboard.donators', $donators) }}</div>
            </div>
        </a>
    </div>

    <div class="col-xs-6 col-lg-3">
        <a class="block block-link-hover1" href="{{ route('admin.publications.index') }}">
            <div class="block-content block-content-full clearfix">
                <div class="pull-right push-15-t push-15">
                    <i class="fas fa-book fa-2x text-primary"></i>
                </div>
                <div class="h2 text-primary" data-toggle="countTo" data-to="{{ $publications }}">{{ $publications }}</div>
                <div class="text-uppercase font-w600 font-s12 text-muted">{{ trans_choice('dashboard.publications', $publications) }}</div>
            </div>
        </a>
    </div>

    <div class="col-xs-6 col-lg-3">
        <a class="block block-link-hover1" href="{{ route('admin.libraries.index') }}">
            <div class="block-content block-content-full clearfix">
                <div class="pull-right push-15-t push-15">
                    <i class="fas fa-bookmark fa-2x text-primary"></i>
                </div>
                <div class="h2 text-primary" data-toggle="countTo" data-to="{{ $libraries }}">{{ $libraries }}</div>
                <div class="text-uppercase font-w600 font-s12 text-muted">{{ trans_choice('dashboard.libraries', $libraries) }}</div>
            </div>
        </a>
    </div>


    <div class="col-xs-6 col-lg-3">
        <a class="block block-link-hover1" href="{{ route('admin.galleries.index') }}">
            <div class="block-content block-content-full clearfix">
                <div class="pull-right push-15-t push-15">
                    <i class="fa fa-images fa-2x text-primary"></i>
                </div>
                <div class="h2 text-primary" data-toggle="countTo" data-to="{{ $galleries }}">{{ $galleries }}</div>
                <div class="text-uppercase font-w600 font-s12 text-muted">{{ trans_choice('dashboard.galleries', $galleries) }}</div>
            </div>
        </a>
    </div>
@endsection
