@extends('layouts.admin')

@section('title')
<i class="fas fa-bookmark"></i> {{ __('Libraries') }}
@endsection

@section('content')
    <div class="block block-rounded block-bordered">
        <div class="block-header">
        <div class="row">
            <div class="md-form mt-0 col-md-6">
            {{--  <form action="{{route('admin.publications.search')}}"><input class="form-control search-users" name="search" type="text" placeholder="{{__('Search publications')}}" aria-label="Search">
                &nbsp;<button type="submit" class="btn btn-sm btn-primary">{{__('Search')}}</button>
                &nbsp;<a class="btn btn-primary btn-sm refresh-search" href="{{ route('admin.publications.index') }}">{{ __('Reset') }}</a> 
            </form>  --}}
            </div>
            <div class="col-md-6">
            <div class="col-md-8 pull-right">
                <a class="btn btn-primary btn-sm pull-right" href="{{ route('admin.library.create') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;{{ __('Create') }}</a> 
            </div>
            </div>
            
        </div>
        </div>
        <div class="block-table">
            
            <table class="table">
                <thead>
                <tr>
                    <th>
                        <a href="/admin/libraries?{{ $filter ? 'filter=libraries&' : '' }}order=title&sort={{ ($order == 'title' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Title')}}</a>
                        @if ($order == 'title')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    {{--  <th>
                        <a href="/admin/publications?{{ $filter ? 'filter=publications&' : '' }}order=active&sort={{ ($order == 'active' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Active')}}</a>
                        @if ($order == 'active')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>  --}}
                    <th>{{__('Active')}}</th>
                    <th>{!!__('Description')!!}</th>
                    <th class="text-center">
                        <a href="/admin/libraries?{{ $filter ? 'filter=created_at&' : '' }}order=created_at&sort={{ ($order == 'created_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Created')}}</a>
                        @if ($order == 'created_at')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th class="text-center">
                        <a href="/admin/libraries?{{ $filter ? 'filter=updated_at&' : '' }}order=updated_at&sort={{ ($order == 'updated_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Updated')}}</a>
                        @if ($order == 'updated_at')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th class="text-center">{{__('Manage')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($libraries as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                         <td>{!!
                        $item->active == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'
                        !!}</td> 

                        <td>{!! str_limit($item->description, 100) !!}</td>
                        <td class="text-center">{{ $item->created_at->format('d. M Y') }}</td>
                        <td class="text-center">{{ $item->updated_at->format('d. M Y') }}</td>
                        <td class="text-center">
                            @if(isset($item->file->filename))
                                <a href="{{ asset('/uploads/libraries/'.$item->file->filename)}}" title="{{__('Download File')}}" download><i class="fas fa-download"></i></a>&nbsp;
                                @else
                            <a class="fas fa-download disabled" title="{{__('File Missing')}}"></a>&nbsp;
                                @endif
                            <a href="{{ route('admin.library.edit', $item->id) }}" title="{{__('Edit library')}}"><i class="fas fa-edit"></i> </a>&nbsp;
                            <a href="{{ route('admin.library.show', $item->id) }}" title="{{__('View library')}}"><i class="fas fa-eye"></i> </a>&nbsp;
                            {{-- <a class="delete__confirm" href="{{ route('admin.library.destroy', $item->id) }}"><i class="fas fa-trash"></i> </a> --}}
                            <a class="delete__confirm" href="#0" data-form-id="{{md5($item->id)}}" title="{{__('Delete library')}}"><i class="fas fa-trash"></i></a>
                                <form id="{{md5($item->id)}}" action="{{ route('admin.library.destroy', $item->id) }}" style="display: none;">
                                    {{ csrf_field() }}{{ method_field('DELETE') }}
                                </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $libraries->links() }}
@endsection

@section('script')
@if ( Config::get('app.locale') == 'en')
<script>
    $('.delete__confirm').on('click', function (e) {
      e.preventDefault();

      var form = $(this).data('form-id');

      swal({
        title: "Are you sure?",
        text: "library will be deleted.",
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
        text: "Knjiga će biti obrisana.",
        icon: "warning",
        buttons: [true, 'Delete']
      }).then(function(value) {
        if (value) $('#' + form).submit();
      });
    })
</script>
@endif
@endsection