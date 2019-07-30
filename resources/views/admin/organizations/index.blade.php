@extends('layouts.admin')

@section('title')
    <i class="fas fa-building"></i> {{ __('Organizations') }}
@endsection
{{--  {{dd($organizations->find(84)->detail->id)}}  --}}
@section('content')
    <div class="block block-rounded block-bordered">
        <div class="block-header">
                <div class="row">
                        {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.search',['search' => 1]) }}"><i class="fas fa-plus"></i> {{ __('userooo') }}</a> --}}
                        <div class="md-form mt-0 col-md-6">
                        <form action="{{route('admin.organizations.search')}}"><input class="form-control search-users" name="search" type="text" placeholder="{{__('Search Organizations')}}" aria-label="Search">
                            &nbsp;<button type="submit" class="btn btn-sm btn-primary">{{__('Search')}}</button>
                            &nbsp;<a class="btn btn-primary btn-sm refresh-search" href="{{ route('admin.organizations.index') }}">{{ __('Reset') }}</a> 
                        </form>
                        </div>
                        <div class="col-md-6">
                        <div class="col-md-8 pull-right">
                            {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.donator') }}"><i class="fas fa-plus"></i> {{ __('Create Donator') }}</a> --}}
                            {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.org') }}"><i class="fas fa-plus"></i> {{ __('Create Organization') }}</a> --}}
                            <a class="btn btn-primary btn-sm pull-right" href="{{ route('admin.users.org') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;{{ __('Create Organization') }}</a> 
                        </div>
                        </div>
                    </div>
        </div>
        <div class="block-table">
            
            <table class="table">
                <thead>
                <tr>
                    <th>{{__('Avatar')}}</th>
                    <th>
                        <a href="/admin/organizations?{{ $filter ? 'filter=organizations&' : '' }}order=name&sort={{ ($order == 'name' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Name')}}</a>
                        @if ($order == 'name')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                        {{-- {{__('Name')}} --}}
                    </th>
                    <th>
                        <a href="/admin/organizations?{{ $filter ? 'filter=organizations&' : '' }}order=active&sort={{ ($order == 'active' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Active')}}</a>
                        @if ($order == 'active')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>
                        <a href="/admin/organizations?{{ $filter ? 'filter=organizations&' : '' }}order=moderator&sort={{ ($order == 'moderator' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Moderator')}}</a>
                        @if ($order == 'moderator')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>{{__('Description')}}</th>
                    <th>
                        <a href="/admin/organizations?{{ $filter ? 'filter=organizations&' : '' }}order=email&sort={{ ($order == 'email' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Email')}}</a>
                        @if ($order == 'email')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                        {{-- {{__('Email')}} --}}
                    </th>
                    <th>
                        <a href="/admin/organizations?{{ $filter ? 'filter=organizations&' : '' }}order=created_at&sort={{ ($order == 'created_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Created')}}</a>
                        @if ($order == 'created_at')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                        {{-- {{__('Created')}} --}}
                    </th>
                    <th>{{__('Manage')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($organizations as $org)
                    <tr>
                        <td>
                            <img src="
                            {{ !$org->avatar == null ? asset('/uploads/avatars/'.$org->avatar) : asset('/img/no-image.png')  }}
                            " alt="organization-logo" width="50">
                        </td>
                        <td>{{ $org->name }}</td>
                        <td>{!!
                            $org->active == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'
                        !!}</td>
                        <td>{!!
                            $org->moderator == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'
                        !!}</td>
                        <td>{{ str_limit($org->description, 50) }}</td>
                        <td><a href="mailto:{{ $org->email }}">{{ $org->email }}</a></td>
                        <td>{{ $org->created_at->format('d. M Y') }}</td>
                        <td>
                            {{--  <a href="{{route('admin.detail.create',$org->id)}}" title="{{__('Add Details')}}"><i class="fas fa-plus"></i></a>&nbsp;  --}}
                            @if (!is_null($org->detail))
                            <a href="{{route('admin.detail.edit',$org->detail->id)}}" title="{{__('Edit Details')}}"><i class="fas fa-list"></i></a>&nbsp;
                            @endif
                            @if (is_null($org->detail))
                            <a href="{{route('admin.detail.create',$org->id)}}" title="{{__('Add Details')}}"><i class="fas fa-plus"></i></a>&nbsp;
                            @endif
                            {{--  <a href="{{route('admin.detail.edit',$org->detail->id)}}" title="{{__('Edit Details')}}"><i class="fas fa-plus"></i></a>&nbsp;  --}}
                            <a href="{{ route('admin.users.edit', $org->id) }}" title="{{__('Edit User')}}"><i class="fas fa-edit"></i></a>&nbsp;
                            {{-- <a class="delete__confirm" href="{{ route('admin.users.destroy', $org->id) }}"><i class="fas fa-trash"></i> </a> --}}
                            <a class="delete__confirm" href="#0" data-form-id="{{md5($org->id)}}" title="{{__('Delete User')}}"><i class="fas fa-trash"></i></a>
                            <form id="{{md5($org->id)}}" action="{{ route('admin.users.destroy', ['user' => $org->id]) }}" method="POST" style="display: none;">
                                {{ csrf_field() }}{{ method_field('DELETE') }}
                            </form>
                        </td>
                    </tr>                 
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $organizations->appends(request()->query())->links() }}
@endsection

@section('script')
@if ( Config::get('app.locale') == 'en')
<script>
    $('.delete__confirm').on('click', function (e) {
      e.preventDefault();

      var form = $(this).data('form-id');

      swal({
        title: "Are you sure?",
        text: "Organization will be deleted.",
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
        text: "Organizacija će biti obrisana.",
        icon: "warning",
        buttons: [true, 'Delete']
      }).then(function(value) {
        if (value) $('#' + form).submit();
      });
    })
</script>
@endif
@endsection