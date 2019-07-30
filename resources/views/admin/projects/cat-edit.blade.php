@extends('layouts.admin')

@section('title')
    <i class="fas fa-forward"></i> {{__('Categories Management')}}
@endsection

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <div class="block block-rounded block-bordered">
            <div class="block-content">
                <form id="update-categories-form" action="{{ route('admin.category.update', $project->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}

                    {{-- <hr class="separator"> --}}
                    <div class="form-group">
                        <label for="approved_funds">{{ __('Approved Funds By Category') }}</label>
                    </div>
                    {{-- {{ dd(url()->current()) }} --}}
                        
                        <table class="table">
                            <thead>
                              <tr>
                              <th>{{ __('Category Name') }}</th>
                              <th>{{ __('Approved') }}</th>
                              <th>{{ __('Cost Type') }}</th>
                              <th>{{ __('Manage') }}</th>
                              </tr>
                            </thead>
                            <tbody>
                                    @foreach ($project->categories as $pro)
                              <tr>
                                <th>{{ $pro->name }}</th>
                                <td>{{ number_format($pro->approved_for_category + $pro->approved_for_category_private, 2) }}</td>
                                <td>
                                    {!! $pro->direct_cost == 1 ? __('Direct') : __('Indirect')  !!}
                                    {{-- {{ $pro->direct_cost }}</td> --}}
                                <td>
                                    <a class="" href="{{ route('admin.category.edit', $pro->id) }}" title="{{__('Edit Category')}}"><i class="fas fa-edit"></i></a>
                                    <a class="delete__confirm text-danger" href="{{ route('admin.category.destroy', $pro->id) }}" title="{{__('Delete Category')}}"><i class="fas fa-trash"></i></a>&nbsp;
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $pro->name }}" name="name[]">
                                @if ($errors->has('name.*'))
                                <div class="text-danger">
                                    {{ $errors->first('name.*') }}
                                </div>
                            @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="category_id[]" class="form-control" value="{{ $pro->id }}" >
                                <input type="text" name="approved_for_category[]" class="form-control" value="{{ $pro->approved_for_category }}">
                                @if ($errors->has('approved_for_category'))
                                <div class="text-danger">
                                    {{ $errors->first('approved_for_category') }}
                                </div>
                            @endif
                                {{--  <input type="checkbox" name="direct_cost[]" class="form-check-input" {{$pro->direct_cost == 1 ? 'checked' : ''}}>&nbsp;  --}}
                                {{-- <a class="delete__confirm text-danger btn btn-danger btn-xs" href="{{ route('admin.category.destroy', $pro->id) }}" title="{{__('Delete Cost')}}"><i class="fas fa-times"></i></a>&nbsp;
                                <a class="" href="{{ route('admin.category.edit', $pro->id) }}" title="{{__('Edit Cost')}}"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                    </div> --}}
                        
                    
                    <div class="form-group">
                        <a class="btn btn-info" href="{{ route('admin.projects.index') }}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
                        {{--  <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>  --}}
                        <a class="btn btn-info" href="{{ route('admin.category.create', $project->id) }}" title="{{__('Add Category')}}"><i class="glyphicon glyphicon-plus"></i></a>
                    </div>
                

{{--  @if($errors)
@foreach ($errors->all() as $error)
   <div>{{ $error }}</div>
@endforeach
@endif  --}}



                </form>
                
            </div>
        </div>
    </div>
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
            text: "Category will be deleted.",
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
            text: "Kategorija ce biti obrisana.",
            icon: "warning",
            buttons: [true, 'Delete']
        }).then(function(value) {
            if (value) window.location = link.href;
        });
    })
</script>
@endif

@endsection