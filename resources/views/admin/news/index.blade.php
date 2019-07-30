@extends('layouts.admin')

@section('title')
    <i class="fas fa-newspaper"></i> {{ __('News') }}
@endsection

@section('content')
    <div class="block block-rounded block-bordered">
        <div class="block-header">
        <div class="row">
            <div class="md-form mt-0 col-md-6">
            <form action="{{route('admin.news.search')}}"><input class="form-control search-users" name="search" type="text" placeholder="{{__('Search News')}}" aria-label="Search">
                &nbsp;<button type="submit" class="btn btn-sm btn-primary">{{__('Search')}}</button>
                &nbsp;<a class="btn btn-primary btn-sm refresh-search" href="{{ route('admin.news.index') }}">{{ __('Reset') }}</a> 
            </form>
            </div>
            <div class="col-md-6">
            <div class="col-md-8 pull-right">
                <a class="btn btn-primary btn-sm pull-right" href="{{ route('admin.news.create') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;{{ __('Create') }}</a> 
            </div>
            </div>
            
        </div>
        </div>
        <div class="block-table">
            
            <table class="table">
                <thead>
                <tr>
                    <th>
                        <a href="/admin/news?{{ $filter ? 'filter=news&' : '' }}order=title&sort={{ ($order == 'title' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Title')}}</a>
                        @if ($order == 'title')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>
                        <a href="/admin/news?{{ $filter ? 'filter=news&' : '' }}order=active&sort={{ ($order == 'active' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Active')}}</a>
                        @if ($order == 'active')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>{!!__('Body')!!}</th>
                    <th class="text-center">
                        <a href="/admin/news?{{ $filter ? 'filter=created_at&' : '' }}order=created_at&sort={{ ($order == 'created_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Created')}}</a>
                        @if ($order == 'created_at')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th class="text-center">
                        <a href="/admin/news?{{ $filter ? 'filter=updated_at&' : '' }}order=updated_at&sort={{ ($order == 'updated_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Updated')}}</a>
                        @if ($order == 'updated_at')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th class="text-left">{{__('Manage')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($news as $item)
                    <tr>
                        <td>{{ str_limit($item->title, 50) }}</td>
                        <td>{!!
                        $item->active == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'
                        !!}</td>
                        <td>{{ str_limit($item->body, 50) }}</td>
                        <td class="text-center">{{ $item->created_at->format('d. M Y') }}</td>
                        <td class="text-center">{{ $item->updated_at->format('d. M Y') }}</td>
                        <td class="text-left">
                            <a href="{{ route('admin.news.edit', $item->id) }}" title="{{__('Edit News')}}"><i class="fas fa-edit"></i> </a>&nbsp;
                            {{-- <a href="{{ route('admin.news.show', $item->id) }}" title="{{__('view news')}}"><i class="fas fa-eye"></i> </a>&nbsp; --}}
                            {{-- <a class="delete__confirm" href="{{ route('admin.news.destroy', $item->id) }}"><i class="fas fa-trash"></i> </a> --}}
                            <a class="delete__confirm" href="#0" data-form-id="{{md5($item->id)}}" title="{{__('Delete News')}}"><i class="fas fa-trash"></i></a>
                                <form id="{{md5($item->id)}}" action="{{ route('admin.news.destroy', $item->id) }}" style="display: none;">
                                    {{ csrf_field() }}{{ method_field('DELETE') }}
                                </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $news->links() }}
@endsection

@section('script')
@if ( Config::get('app.locale') == 'en')
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
@endif

@if ( Config::get('app.locale') == 'sr')
<script>
    $('.delete__confirm').on('click', function (e) {
      e.preventDefault();

      var form = $(this).data('form-id');

      swal({
        title: "Da li ste sigurni?",
        text: "Vest će biti obrisana.",
        icon: "warning",
        buttons: [true, 'Delete']
      }).then(function(value) {
        if (value) $('#' + form).submit();
      });
    })
</script>
@endif
@endsection