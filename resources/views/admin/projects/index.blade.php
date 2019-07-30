@extends('layouts.admin')

@section('title')
    <i class="fas fa-forward"></i> {{ __('Projects') }}
@endsection

@section('content')
{{-- {{dd($projects)}} --}}
    <div class="block block-rounded block-bordered">
        <div class="block-header">
                <div class="row">
                        {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.search',['search' => 1]) }}"><i class="fas fa-plus"></i> {{ __('userooo') }}</a> --}}
                        <div class="md-form mt-0 col-md-6">
                        <form action="{{route('admin.projects.search')}}"><input class="form-control search-users" name="search" type="text" placeholder="{{__('Search Projects')}}" aria-label="Search">
                            &nbsp;<button type="submit" class="btn btn-sm btn-primary">{{__('Search')}}</button>
                            &nbsp;<a class="btn btn-primary btn-sm refresh-search" href="{{ route('admin.projects.index') }}">{{ __('Reset') }}</a> 
                        </form>
                        </div>
                        <div class="col-md-6">
                        <div class="col-md-8 pull-right">
                            {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.donator') }}"><i class="fas fa-plus"></i> {{ __('Create Donator') }}</a> --}}
                            {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.users.org') }}"><i class="fas fa-plus"></i> {{ __('Create Organization') }}</a> --}}
                            <a class="btn btn-primary btn-sm pull-right" href="{{ route('admin.project.create') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;{{ __('Create') }}</a> 
                        </div>
                        </div>
                        
                    </div>
        </div>
        <div class="block-table">
            <table class="table">
                <thead>
                <tr>
                    <th><a href="/admin/projects?{{ $filter ? 'filter=projects&' : '' }}order=title&sort={{ ($order == 'title' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Title') }}</a>
                        @if ($order == 'title')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>                    
                    <th>{{ __('Description') }}</th>
                    <th><a href="/admin/projects?{{ $filter ? 'filter=projects&' : '' }}order=users.name&sort={{ ($order == 'users.name' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Organization') }}</a>
                        @if ($order == 'users.name')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>
                        <a href="/admin/projects?{{ $filter ? 'filter=projects&' : '' }}order=users.name&sort={{ ($order == 'users.name' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Donator') }}</a>
                        @if ($order == 'users.name')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>
                        <a href="/admin/projects?{{ $filter ? 'filter=projects&' : '' }}order=approved_funds&sort={{ ($order == 'approved_funds' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Approved Funds') }}</a>
                        @if ($order == 'approved_funds')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>
                        <a href="/admin/projects?{{ $filter ? 'filter=projects&' : '' }}order=remaining_funds&sort={{ ($order == 'remaining_funds' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Spent Funds') }}</a>
                        @if ($order == 'remaining_funds')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th>
                        <a href="/admin/projects?{{ $filter ? 'filter=projects&' : '' }}order=spent_funds&sort={{ ($order == 'spent_funds' && $sort == 'asc') ? 'desc' : 'asc' }}">{{ __('Remaining Funds') }}</a>
                        @if ($order == 'spent_funds')
                            <i class="fa fa-sort-{{ $sort == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </th>
                    <th class="text-center">{{ __('Manage') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)           
                    <tr>

                        <td>{{ str_limit($project->title, 30) }}</td>
                        <td>{{ str_limit($project->description, 30) }}</td>
                        {{-- <td><a href="#" data-toggle="tooltip" title="{{ $project->description }}">Description</a></td> --}}
                        <td>{{ $project->organization->name }}</td>
                        <td>{{ $project->donator->name }}</td>
                        <td>{{ number_format($project->approved_funds, 2) }}</td>
                        <td>{{ number_format($project->spent_funds, 2) }}</td>
                        <td>{{ number_format($project->remaining_funds, 2) }}</td>
                        <td class="text-center">
                        {{-- <a href="{{ route('admin.costs.create', $project->id)  }}" title="add"><i class="fas fa-plus-circle"></i> </a>&nbsp; --}}
                        <a href="{{ route('admin.project-cat.update', $project->id) }}" title="{{__('Manage Categories')}}"><i class="fas fa-plus"></i></a>&nbsp;
                        <a href="{{ route('admin.project.show', $project->id)  }}" title="{{__('Show Project')}}"><i class="fas fa-file"></i> </a>&nbsp;
                                <a href="{{ route('admin.project.edit', $project->id) }}" title="{{__('Edit Project')}}"><i class="fas fa-edit"></i> </a>&nbsp;
                                {{-- <a class="delete__confirm" href="{{ route('admin.project.destroy', $project->id) }}"><i class="fas fa-trash"></i> </a> --}}
                                <a class="delete__confirm" href="#0" data-form-id="{{md5($project->id)}}" title="{{__('Delete Project')}}"><i class="fas fa-trash"></i></a>
                                <form id="{{md5($project->id)}}" action="{{ route('admin.project.destroy', $project->id) }}" style="display: none;">
                                    {{ csrf_field() }}{{ method_field('DELETE') }}
                                </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $projects->appends(request()->query())->links() }}
@endsection
@section('script')
@if ( Config::get('app.locale') == 'en')
<script>
    $('.delete__confirm').on('click', function (e) {
      e.preventDefault();

      var form = $(this).data('form-id');

      swal({
        title: "Are you sure?",
        text: "Project will be deleted.",
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
        text: "Projekat će biti obrisan.",
        icon: "warning",
        buttons: [true, 'Delete']
      }).then(function(value) {
        if (value) $('#' + form).submit();
      });
    })
</script>
@endif}

@endsection
