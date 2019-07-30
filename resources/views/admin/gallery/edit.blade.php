@extends('layouts.admin') 
@section('title')
<i class="fa fa-images"></i> {{__('Gallery')}}
@endsection
 
@section('subtitle')
    {{__('Edit')}}
@endsection
@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form id="gallery-update-form" action="{{ route('admin.gallery.update', $gallery->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="form-group required">
                    <label for="question">{{ __('Title') }}</label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title', $gallery->title) }}">
                    @if ($errors->has('title'))
                    <div class="text-danger">
                        {{ $errors->first('title') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="active">{{ __('Active') }}&nbsp;</label>
                    <input type="checkbox" name="active" class="form-check-input" {{$gallery->active == 1 ? 'checked' : ''}}
                    >
                </div>

                <div class="form-group required">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea name="description" id="editor">{{ $gallery->description }}</textarea>
                    @if ($errors->has('description'))
                        <div class="text-danger">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="slides">{{ __('Slides') }}</label>
                </div>


                @if ($gallery->slides()->exists())
                @foreach($gallery->slides as $slide)
                <div class="col-md-4 image-edit">
                    <div class="form-group">
                        <a class="delete__confirm" href="{{ route('admin.gallery_image.destroy', $slide->id) }}"><i class="fa fa-times-circle"></i></a>
                        <img src="{{asset('uploads/galleries/' . $slide->filename)}}" height="100">
                    </div>
                </div>
                @endforeach
                @endif {{-- <input name="flyers[]" type="file" accept="image/*" multiple> --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="clone hide">
                                <div class="control-group input-group" style="margin-top:10px">
                                    <input type="file" name="slides[]">
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger button-remove" type="button"><i class="glyphicon glyphicon-remove"></i> {{ __('Remove') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group form-group control-group increment">
                            <input type="file" name="slides[]">
                            <div class="input-group-btn">
                                <button class="btn btn-success button-add" type="button"><i class="glyphicon glyphicon-plus"></i> {{ __('Add') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <a class="btn btn-danger" href="{{ route('admin.galleries.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                        <button type="submit" form="gallery-update-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                    </div>
                </div>
        </div>


        </form>
    </div>
</div>
</div>
@endsection

@section('script')
    @include('admin._summernote')
    @if ( Config::get('app.locale') == 'en')
    <script>
        $('.delete__confirm').on('click', function (e) {
          e.preventDefault();
    
        //   var form = $(this).data('form-id');
        var link = this;
    
          swal({
            title: "Are you sure?",
            text: "Gallery image will be deleted.",
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
    
        //   var form = $(this).data('form-id');
        var link = this;
    
          swal({
            title: "Da li ste sigurni?",
            text: "Slajd će biti obrisana.",
            icon: "warning",
            buttons: [true, 'Delete']
          }).then(function(value) {
            if (value) window.location = link.href;
          });
        })
    </script>
    @endif
<script>
    $(document).ready(function() {
    
          $(".button-add").click(function(){ 
              var html = $(".clone").html();
              $(".increment").after(html);
          });
    
          $("body").on("click",".button-remove",function(){ 
              $(this).parents(".control-group").remove();
          });
    
        });
</script>
@endsection