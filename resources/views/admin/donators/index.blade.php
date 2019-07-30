@extends('layouts.admin')

@section('title')
    <i class="fas fa-handshake"></i> {{__('Donators')}}
@endsection
@section('content')
    <div class="block block-rounded block-bordered">
        <div class="block-header">
                <div class="row">
                        {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.search',['search' => 1]) }}"><i class="fas fa-plus"></i> {{ __('userooo') }}</a> --}}
                        <div class="md-form mt-0 col-md-6">
                        <form action="{{route('admin.donators.search')}}"><input class="form-control search-users" name="search" type="text" placeholder="{{__('Search Donators')}}" aria-label="Search">
                            &nbsp;<button type="submit" class="btn btn-sm btn-primary">{{__('Search')}}</button>
                            &nbsp;<a class="btn btn-primary btn-sm refresh-search" href="{{ route('admin.donators.index') }}">{{ __('Reset') }}</a> 
                        </form>
                        </div>
                        <div class="col-md-6">
                        <div class="col-md-8 pull-right">
                            {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.donator') }}"><i class="fas fa-plus"></i> {{ __('Create Donator') }}</a> --}}
                            {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.org') }}"><i class="fas fa-plus"></i> {{ __('Create Organization') }}</a> --}}
                            <a class="btn btn-primary btn-sm pull-right" href="{{ route('admin.users.donator') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;{{ __('Create Donator') }}</a> 
                        </div>
                        </div>
                    </div>
        </div>
        <div class="block-table">
            <table class="table">
                <thead>
                <tr>
                    <th class="text-center">Avatar</th>
                    {{-- <th>
                        {{__('Name')}}
                    </th> --}}
                    <th>
                        <a href="/admin/donators?{{ $filter ? 'filter=donators&' : '' }}order=name&sort={{ ($order == 'name' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Name')}}</a>
                        @if ($order == 'name')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>
                        <a href="/admin/donators?{{ $filter ? 'filter=donators&' : '' }}order=active&sort={{ ($order == 'active' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Active')}}</a>
                        @if ($order == 'active')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>
                        <a href="/admin/donators?{{ $filter ? 'filter=donators&' : '' }}order=moderator&sort={{ ($order == 'moderator' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Moderator')}}</a>
                        @if ($order == 'moderator')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>{{__('Description')}}</th>
                    <th class="text-center">
                        <a href="/admin/donators?{{ $filter ? 'filter=donators&' : '' }}order=email&sort={{ ($order == 'email' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Email')}}</a>
                        @if ($order == 'email')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                        {{-- {{__('Email')}} --}}
                    </th>
                    <th class="text-center">
                        <a href="/admin/donators?{{ $filter ? 'filter=donators&' : '' }}order=created_at&sort={{ ($order == 'created_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Created')}}</a>
                        @if ($order == 'created_at')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                        {{-- {{__('Created')} --}}
                    </th>
                    <th class="text-center">{{__('Manage')}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($donators as $donator)
                    <tr>
                        <td class="text-center">
                             <img src="
                            {{ !$donator->avatar == null ? asset('/uploads/avatars/'.$donator->avatar) : asset('/img/no-image.png')  }}
                            " alt="donator-logo" width="50">
                        </td>
                        <td>{{ $donator->name }}</td>
                        <td>{!!
                                $donator->active == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'
                            !!}</td>
                        <td>{!!
                                $donator->moderator == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'
                            !!}</td>
                        <td>{!! str_limit($donator->description, 50) !!}</td>
                        {{-- <td><a href="#" data-toggle="tooltip" title="{{ strip_tags($donator->description) }}">About Donator</a></td> --}}
                        <td class="text-center"><a href="mailto:{{ $donator->email }}">{{ $donator->email }}</a></td>
                        <td class="text-center">{{ $donator->created_at->format('d. M Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.users.edit', $donator->id) }}" title="{{__('Edit User')}}"><i class="fas fa-edit"></i></a>&nbsp;
                            <a class="delete__confirm" href="#0" data-form-id="{{md5($donator->id)}}" title="{{__('Delete User')}}"><i class="fas fa-trash"></i></a>
                            <form id="{{md5($donator->id)}}" action="{{ route('admin.users.destroy', $donator->id) }}" method="POST" style="display: none;">
                                {{ csrf_field() }}{{ method_field('DELETE') }}
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $donators->appends(request()->query())->links() }}
@endsection
@section('script')
@if ( Config::get('app.locale') == 'en')
    <script>
        $('.delete__confirm').on('click', function (e) {
          e.preventDefault();

          var form = $(this).data('form-id');

          swal({
            title: "Are you sure?",
            text: "Donator will be deleted.",
            icon: "warning",
            buttons: [true, 'Delete']
          }).then(function(value) {
            if (value) $('#' + form).submit();
          });
        })
    </script>
@endif

@if ( Config::get('app.locale') == 'sr')
    <script>
        $('.delete__confirm').on('click', function (e) {
          e.preventDefault();

          var form = $(this).data('form-id');

          swal({
            title: "Da li ste sigurni?",
            text: "Donator će biti obrisan.",
            icon: "warning",
            buttons: [true, 'Delete']
          }).then(function(value) {
            if (value) $('#' + form).submit();
          });
        })
    </script>
@endif
   
@endsection
