@extends('layouts.admin')

@section('title')
<i class="fa fa-images"></i> {{ __('Galleries') }}
@endsection

@section('content')
    <div class="block block-rounded block-bordered">
        <div class="block-header">
        <div class="row">
            <div class="md-form mt-0 col-md-6">
            {{--  <form action="{{route('admin.galleries.search')}}"><input class="form-control search-users" name="search" type="text" placeholder="{{__('Search galleries')}}" aria-label="Search">
                &nbsp;<button type="submit" class="btn btn-sm btn-primary">{{__('Search')}}</button>
                &nbsp;<a class="btn btn-primary btn-sm refresh-search" href="{{ route('admin.galleries.index') }}">{{ __('Reset') }}</a> 
            </form>  --}}
            </div>
            <div class="col-md-6">
            <div class="col-md-8 pull-right">
                <a class="btn btn-primary btn-sm pull-right" href="{{ route('admin.gallery.create') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;{{ __('Create') }}</a> 
            </div>
            </div>
            
        </div>
        </div>
        <div class="block-table">
            
            <table class="table">
                <thead>
                <tr>
                    <th>{{__('Title')}}</th>
                    {{-- <th>
                        <a href="/admin/galleries?{{ $filter ? 'filter=galleries&' : '' }}order=title&sort={{ ($order == 'title' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Title')}}</a>
                        @if ($order == 'title')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th> --}}
                    {{--  <th>
                        <a href="/admin/galleries?{{ $filter ? 'filter=galleries&' : '' }}order=active&sort={{ ($order == 'active' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Active')}}</a>
                        @if ($order == 'active')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>  --}}
                    <th>{{ __('Active') }}</th>
                    <th>{!!__('Description')!!}</th>
                    <th class="text-center">
                            {{__('Created')}}
                        {{-- <a href="/admin/galleries?{{ $filter ? 'filter=created_at&' : '' }}order=created_at&sort={{ ($order == 'created_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Created')}}</a>
                        @if ($order == 'created_at')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif --}}
                    </th>
                    <th class="text-center">
                            {{__('Updated')}}
                        {{-- <a href="/admin/galleries?{{ $filter ? 'filter=updated_at&' : '' }}order=updated_at&sort={{ ($order == 'updated_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Updated')}}</a>
                        @if ($order == 'updated_at')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif --}}
                    </th>
                    <th class="text-center">{{__('Manage')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($galleries as $gallery)
                    <tr>
                        <td>{{ $gallery->title }}</td>
                         <td>{!!
                        $gallery->active == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'
                        !!}</td> 
                        <td>{!! str_limit($gallery->description, 100) !!}</td>
                        <td class="text-center">{{ $gallery->created_at->format('d. M Y') }}</td>
                        <td class="text-center">{{ $gallery->updated_at->format('d. M Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.gallery.edit', $gallery->id) }}" title="{{__('Edit gallery')}}"><i class="fas fa-edit"></i> </a>&nbsp;
                            <a href="{{ route('admin.gallery.show', $gallery->id) }}" title="{{__('View gallery')}}"><i class="fas fa-eye"></i> </a>&nbsp;
                            {{-- <a class="delete__confirm" href="{{ route('admin.gallery.destroy', $gallery->id) }}" title="{{__('Delete gallery')}}"><i class="fas fa-trash"></i> </a> --}}
                            <a class="delete__confirm" href="#0" data-form-id="{{md5($gallery->id)}}" title="{{__('Delete gallery')}}"><i class="fas fa-trash"></i></a>
                                <form id="{{md5($gallery->id)}}" action="{{ route('admin.gallery.destroy', $gallery->id) }}" style="display: none;">
                                    {{ csrf_field() }}{{ method_field('DELETE') }}
                                </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- {{ $galleries->links() }} --}}
@endsection

@section('script')
@if ( Config::get('app.locale') == 'en')
<script>
    $('.delete__confirm').on('click', function (e) {
      e.preventDefault();

      var form = $(this).data('form-id');

      swal({
        title: "Are you sure?",
        text: "Gallery will be deleted.",
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
        text: "Galerija će biti obrisana.",
        icon: "warning",
        buttons: [true, 'Delete']
      }).then(function(value) {
        if (value) $('#' + form).submit();
      });
    })
</script>
@endif
@endsection