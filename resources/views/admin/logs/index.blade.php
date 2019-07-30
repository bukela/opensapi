@extends('layouts.admin')

@section('title')
    <i class="fas fa-file-alt"></i> {{ __('Logs') }}
@endsection

@section('content')
    
    <div class="block block-rounded block-bordered">
        <div class="block-header">
            <div class="md-form mt-0 col-md-6">
                <form action="{{route('admin.logs.search')}}"><input class="form-control search-users" name="search" type="text" placeholder="{{__('Search Logs')}}" aria-label="Search">
                    &nbsp;<button type="submit" class="btn btn-sm btn-primary">{{__('Search')}}</button>
                    &nbsp;<a class="btn btn-primary btn-sm refresh-search" href="{{ route('admin.logs.index') }}">{{ __('Reset') }}</a> 
                </form>
            </div>
            <div class="block-options-simple" style="float: right">
                <a class="delete__confirm btn btn-danger btn-sm" href="{{ route('admin.logs.destroy') }}"><i class="fas fa-trash"></i> {{ __('Clear Logs') }}</a>
            </div>
        </div>
        <div class="block-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <a href="/admin/logs?{{ $filter ? 'filter=logs&' : '' }}order=created_at&sort={{ ($order == 'created_at' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Date & Time') }}</a>
                            @if ($order == 'created_at')
                                <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fa fa-sort"></i>
                            @endif
                        </th>
                        <th>
                            <a href="/admin/logs?{{ $filter ? 'filter=username&' : '' }}order=username&sort={{ ($order == 'username' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('User') }}</a>
                            @if ($order == 'username')
                                <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fa fa-sort"></i>
                            @endif
                        </th>
                        <th>
                            <a href="/admin/logs?{{ $filter ? 'filter=model&' : '' }}order=model&sort={{ ($order == 'model' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Group') }}</a>
                            @if ($order == 'model')
                                <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fa fa-sort"></i>
                            @endif
                        </th>
                        <th width="60%">{{ __('Message') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($logger as $log)
                    <tr>
                        <td>{{$log->created_at->format('d/m/Y H:i:s')}}</td>
                        <td>{{$log->username}}</td>
                        <td>{{$log->model}}</td>
                        <td>{!! $log->description !!}</td>
                        {{--<td class="text-center">--}}
                            {{--<a class="delete__confirm" href="#0" data-form-id="{{md5($log->id)}}"><i class="fas fa-trash"></i></a>--}}
                            {{--<form id="{{md5($log->id)}}" action="{{ route('admin.logs.destroy', $log->id) }}" style="display: none;">--}}
                                {{--{{ csrf_field() }}{{ method_field('DELETE') }}--}}
                            {{--</form>--}}
                        {{--</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $logger->appends(request()->query())->links() }}
@endsection

@section('script')
@if ( Config::get('app.locale') == 'en')
<script>
    $('.delete__confirm').on('click', function (e) {
        e.preventDefault();

        // var form = $(this).data('form-id');
        var link = this;

        swal({
            title: "Are you sure?",
            text: "All logs will be deleted.",
            icon: "warning",
            buttons: [true, 'Delete']
        }).then(function(value) {
            if (value) window.location = link.href;
        });
    })
</script>
@endif

@if ( Config::get('app.locale') == 'sr')
<script>
    $('.delete__confirm').on('click', function (e) {
        e.preventDefault();

        // var form = $(this).data('form-id');
        var link = this;

        swal({
            title: "Da li ste sigurni?",
            text: "Logovi će biti obrisani.",
            icon: "warning",
            buttons: [true, 'Delete']
        }).then(function(value) {
            if (value) window.location = link.href;
        });
    })
</script>
@endif
        
@endsection


