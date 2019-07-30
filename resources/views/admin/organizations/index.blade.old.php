@extends('layouts.admin')

@section('title')
    <i class="fas fa-building"></i> {{ __('Organizations') }}
@endsection

@section('content')
    <div class="block block-rounded block-bordered">
        <div class="block-header">
            <div class="block-options-simple">
                <a class="btn btn-primary btn-sm" href="{{ route('admin.organization.create') }}"><i class="fas fa-plus"></i> {{ __('Create') }}</a>
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
                    </th>
                    <th>{{__('Description')}}</th>
                    <th>
                        <a href="/admin/organizations?{{ $filter ? 'filter=organizations&' : '' }}order=email&sort={{ ($order == 'email' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Email')}}</a>
                        @if ($order == 'email')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>
                        <a href="/admin/organizations?{{ $filter ? 'filter=organizations&' : '' }}order=created_at&sort={{ ($order == 'created_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Created')}}</a>
                        @if ($order == 'created_at')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
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
                        <td>{{ str_limit($org->description, 50) }}</td>
                        <td><a href="mailto:{{ $org->email }}">{{ $org->email }}</a></td>
                        <td>{{ $org->created_at->format('d.M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.organization.edit', $org->id) }}"><i class="fas fa-edit"></i></a>&nbsp;
                            {{-- <a class="delete__confirm" href="{{ route('admin.news.destroy', $org->id) }}"><i class="fas fa-trash"></i> </a> --}}
                            <a class="delete__confirm" href="#0" data-form-id="{{md5($org->id)}}"><i class="fas fa-trash"></i></a>
                                <form id="{{md5($org->id)}}" action="{{ route('admin.organization.destroy', $org->id) }}" style="display: none;">
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
    <script>
      $('.delete__confirm').on('click', function (e) {
        e.preventDefault();

        var form = $(this).data('form-id');

        swal({
          title: "Are you sure?",
          text: "News will be deleted.",
          icon: "warning",
          buttons: [true, 'Delete']
        }).then(function(value) {
          if (value) $('#' + form).submit();
        });
      })
    </script>
@endsection