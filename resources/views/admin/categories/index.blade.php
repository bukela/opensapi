@extends('layouts.admin')

@section('title')
    <i class="fas fa-newspaper"></i> {{ __('Category') }}
@endsection

@section('content')
    <div class="block block-rounded block-bordered">
        <div class="block-header">
            <div class="block-options-simple">
                <a class="btn btn-primary btn-sm" href="{{ route('admin.news.create') }}"><i class="fas fa-plus"></i> {{ __('Create') }}</a>
            </div>
        </div>
        <div class="block-table">
            
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Content') }}</th>
                    <th class="text-center">{{ __('Created') }}</th>
                    <th class="text-center">{{ __('Updated') }}</th>
                    <th class="text-left">{{ __('Manage') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($news as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{!! str_limit($item->body, 30) !!}</td>
                        <td class="text-center">{{ $item->created_at->format('d.M Y') }}</td>
                        <td class="text-center">{{ $item->updated_at->format('d.M Y') }}</td>
                        <td class="text-left">
                            <a href="{{ route('admin.news.edit', $item->id) }}"><i class="fas fa-edit"></i> </a>&nbsp;
                            {{-- <a class="delete__confirm" href="{{ route('admin.news.destroy', $item->id) }}"><i class="fas fa-trash"></i> </a> --}}
                            <a class="delete__confirm" href="#0" data-form-id="{{md5($item->id)}}"><i class="fas fa-trash"></i></a>
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
    {{-- {{ $news->links() }} --}}
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