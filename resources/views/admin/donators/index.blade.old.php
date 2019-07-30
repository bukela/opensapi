@extends('layouts.admin')

@section('title')
    <i class="fas fa-handshake"></i> Donators
@endsection

@section('content')
    <div class="block block-rounded block-bordered">
        {{-- <div class="block-header">
            <div class="block-options-simple">
                <a class="btn btn-primary btn-sm" href="{{ route('admin.organization.create') }}"><i class="fas fa-plus"></i> Create</a>
            </div>
        </div> --}}
        <div class="block-table">
            <table class="table">
                <thead>
                <tr>
                    <th class="text-center">Avatar</th>
                    <th>
                        <a href="/admin/donators?{{ $filter ? 'filter=donators&' : '' }}order=name&sort={{ ($order == 'name' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Name')}}</a>
                        @if ($order == 'name')
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
                    </th>
                    <th class="text-center">
                        <a href="/admin/donators?{{ $filter ? 'filter=donators&' : '' }}order=created_at&sort={{ ($order == 'created_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Created')}}</a>
                        @if ($order == 'created_at')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
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
                        <td>{!! $donator->description !!}</td>
                        {{-- <td><a href="#" data-toggle="tooltip" title="{{ strip_tags($donator->description) }}">About Donator</a></td> --}}
                        <td class="text-center"><a href="mailto:{{ $donator->email }}">{{ $donator->email }}</a></td>
                        <td class="text-center">{{ $donator->created_at->format('d.M Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.users.edit', $donator->id) }}"><i class="fas fa-edit"></i></a>&nbsp;
                            @if(auth()->user()->id !== $donator->id)
                                <a class="delete__confirm" href="#0" data-form-id="{{md5($donator->id)}}"><i class="fas fa-trash"></i></a>
                                <form id="{{md5($donator->id)}}" action="{{ route('admin.users.destroy', ['user' => $donator->id]) }}" method="POST" style="display: none;">
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
    {{-- {{ $donatoranizations->links() }} --}}
@endsection
@section('script')
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
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
@endsection
