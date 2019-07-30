@extends('layouts.admin')

@section('title')
    <i class="fas fa-calendar-alt"></i> {{ __('Events') }}
@endsection

@section('content')
    <div class="block block-rounded block-bordered">
        <div class="block-header">
                <div class="row">
                        <div class="md-form mt-0 col-md-6">
                        <form action="{{route('admin.events.search')}}"><input class="form-control search-users" name="search" type="text" placeholder="{{__('Search Events')}}" aria-label="Search">
                            &nbsp;<button type="submit" class="btn btn-sm btn-primary">{{__('Search')}}</button>
                            &nbsp;<a class="btn btn-primary btn-sm refresh-search" href="{{ route('admin.events.index') }}">{{ __('Reset') }}</a> 
                        </form>
                        </div>
                        <div class="col-md-6">
                        <div class="col-md-8 pull-right">
                            <a class="btn btn-primary btn-sm pull-right" href="{{ route('admin.events.create') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;{{ __('Create') }}</a> 
                        </div>
                        </div>
                        
                    </div>
        </div>
        <div class="block-table">
            
            <table class="table">
                <thead>
                <tr>
                    <th>
                        <a href="/admin/events?{{ $filter ? 'filter=events&' : '' }}order=title&sort={{ ($order == 'title' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Title')}}</a>
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
                    <th>
                        {{__('Content')}}
                    </th>
                    <th>
                        <a href="/admin/events?{{ $filter ? 'filter=events&' : '' }}order=start_date&sort={{ ($order == 'start_date' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('Start Date')}}</a>
                        @if ($order == 'start_date')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    
                    <th>
                        <a href="/admin/events?{{ $filter ? 'filter=events&' : '' }}order=end_date&sort={{ ($order == 'end_date' && $sort == 'asc') ? 'desc' : 'asc' }}">{{__('End Date')}}</a>
                        @if ($order == 'end_date')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th class="text-left">{{__('Manage')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($events as $item)
                    <tr>
                        <td>{{ str_limit($item->title, 50) }}</td>
                        <td class="text-center">{!!
                            $item->active == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'
                        !!}</td>
                        <td width="50%">{{ str_limit($item->content, 50) }}</td>
                        <td>{{ !$item->start_date == null ? date('d. M Y', strtotime($item->start_date)) : 'N/A' }}</td>
                        <td>{{ !$item->end_date == null ? date('d. M Y', strtotime($item->end_date)) : 'N/A' }}</td>
                        <td class="text-left">
                            <a href="{{ route('admin.events.edit', ['events' => $item->id]) }}" title="{{__('Edit Event')}}"><i class="fas fa-edit"></i> </a>
                            &nbsp;
                            {{-- <a class="delete__confirm" href="{{ route('admin.events.destroy', ['events' => $item->id]) }}"><i class="fas fa-trash"></i> </a> --}}
                            <a class="delete__confirm" href="#0" data-form-id="{{md5($item->id)}}" title="{{__('Delete Event')}}"><i class="fas fa-trash"></i></a>
                                <form id="{{md5($item->id)}}" action="{{ route('admin.events.destroy', $item->id) }}" style="display: none;">
                                    {{ csrf_field() }}{{ method_field('DELETE') }}
                                </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $events->links() }}
@endsection

@section('script')
@if ( Config::get('app.locale') == 'en')
<script>
    $('.delete__confirm').on('click', function (e) {
      e.preventDefault();

      var form = $(this).data('form-id');

      swal({
        title: "Are you sure?",
        text: "Event will be deleted.",
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
        text: "Događaj će biti obrisan.",
        icon: "warning",
        buttons: [true, 'Delete']
      }).then(function(value) {
        if (value) $('#' + form).submit();
      });
    })
</script>
@endif
@endsection