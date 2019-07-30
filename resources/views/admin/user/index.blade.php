@extends('layouts.admin')

@section('title')
    <i class="fas fa-users"></i> {{ __('Users') }}
@endsection
{{--  {{ dd(auth()->user()->isAdmin()) }}  --}}
@section('content')
    <div class="block block-rounded block-bordered">
        <div class="block-header">
            <div class="row">
                {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.search',['search' => 1]) }}"><i class="fas fa-plus"></i> {{ __('userooo') }}</a> --}}
                <div class="md-form mt-0 col-md-6">
                <form action="{{route('admin.users.search')}}"><input class="form-control search-users" name="search" type="text" placeholder="{{__('Search Users')}}" aria-label="Search">
                    &nbsp;<button type="submit" class="btn btn-sm btn-primary">{{__('Search')}}</button>
                    &nbsp;<a class="btn btn-primary btn-sm refresh-search" href="{{ route('admin.users.index') }}">{{ __('Reset') }}</a> 
                </form>
                </div>
                <div class="col-md-6">
                <div class="col-md-8 pull-right">
                    {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.donator') }}"><i class="fas fa-plus"></i> {{ __('Create Donator') }}</a> --}}
                    {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.org') }}"><i class="fas fa-plus"></i> {{ __('Create Organization') }}</a> --}}
                    <a class="btn btn-primary btn-sm pull-right" href="{{ route('admin.users.create') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;{{ __('Create User') }}</a> 
                </div>
                </div>
                
            </div>
        </div>
        <div class="block-table">
            <table class="table">
                <thead>
                <tr>
                    <th>Avatar</th>
                    <th><a href="/admin/users?{{ $filter ? 'filter=users&' : '' }}order=name&sort={{ ($order == 'name' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Name') }}</a>
                        @if ($order == 'name')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>
                        <a href="/admin/users?{{ $filter ? 'filter=users&' : '' }}order=active&sort={{ ($order == 'active' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Active')}}</a>
                        @if ($order == 'active')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>
                        <a href="/admin/users?{{ $filter ? 'filter=users&' : '' }}order=moderator&sort={{ ($order == 'moderator' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Moderator')}}</a>
                        @if ($order == 'moderator')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th><a href="/admin/users?{{ $filter ? 'filter=users&' : '' }}order=email&sort={{ ($order == 'email' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Email') }}</a>
                        @if ($order == 'email')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th><a href="/admin/users?{{ $filter ? 'filter=users&' : '' }}order=role_id&sort={{ ($order == 'role_id' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Role') }}</a>
                        @if ($order == 'role_id')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th class="text-center"><a href="/admin/users?{{ $filter ? 'filter=users&' : '' }}order=created_at&sort={{ ($order == 'created_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Registered') }}</a>
                        @if ($order == 'created_at')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th class="text-center">{{ __('Manage') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><img src="{{ !$user->avatar == null ? asset('/uploads/avatars/'.$user->avatar) : asset('/img/no-image.png') }}" alt="donator-logo" width="60" height="50"></td>
                        <td>{{ $user->name}}</td>
                        <td>{!!
                            $user->active == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'
                        !!}</td>
                        <td>{!!
                            $user->moderator == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'
                        !!}</td>
                        <td><a href="mailto:{{ $user->email}}">{{ $user->email}}</a></td>
                        <td>{{ !empty($user->role) ? $user->role->name : 'unknown' }}</td>
                        <td class="text-center">
                            {{ !$user->created_at == null ? $user->created_at->format('d. M Y') : 'N/A' }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" title="{{__('Edit User')}}"><i class="fas fa-edit"></i></a>
                            @if(auth()->user()->id !== $user->id)
                                <a class="delete__confirm" href="#0" data-form-id="{{md5($user->id)}}" title="{{__('Delete User')}}"><i class="fas fa-trash"></i></a>
                                <form id="{{md5($user->id)}}" action="{{ route('admin.users.destroy', ['user' => $user->id]) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}{{ method_field('DELETE') }}
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $users->appends(request()->query())->links() }}
@endsection

@section('script')
@if ( Config::get('app.locale') == 'en')
    <script>
        $('.delete__confirm').on('click', function (e) {
          e.preventDefault();

          var form = $(this).data('form-id');

          swal({
            title: "Are you sure?",
            // text: "User will be deleted.",
            text: "User will be deleted!!! \n All user related projects will be deleted!!!",
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
            text: "Korisnik će biti obrisan!!! \n PROJEKTI VEZANI ZA KORISNIKA ĆE BITI OBRISANI!!!",
            icon: "warning",
            buttons: [true, 'Delete']
          }).then(function(value) {
            if (value) $('#' + form).submit();
          });
        })
    </script>
@endif
@endsection
