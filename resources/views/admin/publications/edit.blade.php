@extends('layouts.admin')

@section('title')
    <i class="fas fa-book"></i> {{__('Publication')}}
@endsection

@section('subtitle')
    {{__('Edit')}}
@endsection

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form id="publication-update-form" action="{{ route('admin.publication.update', $publication->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group required">
                    <label for="question">{{ __('Title') }}</label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $publication->title }}">
                    @if ($errors->has('title'))
                        <div class="text-danger">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                  <label class="form-check-label" for="active">{{ __('Active') }}&nbsp;</label>
                  <input type="checkbox" name="active" class="form-check-input" {{$publication->active == 1 ? 'checked' : ''}}
                  >
              </div>

                <div class="form-group required">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea name="description" id="editor" rows="5" class="form-control">{{ $publication->description }}</textarea>
                    @if ($errors->has('description'))
                        <div class="text-danger">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>


                <div class="form-group">
                    <label for="images">{{__('File')}}</label>
                </div>

                    <div class="form-group">
                        
                        @if($publication->file)
                        @if (in_array(pathinfo($publication->file->filename, PATHINFO_EXTENSION),['pdf','doc','docx','zip','pptx']))
                        <div class="form-group">
                            <img src="{{asset('uploads/publications/documents.png')}}" height="100">
                            <a class="delete__confirm" href="{{ route('admin.publication_image.destroy', $publication->file->id) }}"><i class="fa fa-times-circle"></i></a>
                        </div>
                        @else
                        <div class="form-group">
                            <img src="{{asset('uploads/publications/' . $publication->file->filename)}}" height="100">
                            <a class="delete__confirm" href="{{ route('admin.publication_image.destroy', $publication->file->id) }}"><i class="fa fa-times-circle"></i></a>
                        </div>
                        @endif
                        @endif
                        <input name="file" type="file">
                        @if ($errors->has('file'))
                        <div class="text-danger">
                            {{ $errors->first('file') }}
                        </div>
                    @endif
                    </div>
                      {{-- <div class="input-group-btn"> 
                        <button class="btn btn-danger button-remove" type="button"><i class="glyphicon glyphicon-remove"></i> {{ __('Remove') }}</button>
                      </div>
                    </div>
                  </div>
                <div class="input-group control-group increment" >
                    <input type="file" name="files[]">
                    @if ($errors->has('files.*'))
                        <div class="text-danger">
                            {{ $errors->first('files.*') }}
                        </div>
                    @endif
                    <div class="input-group-btn"> 
                      <button class="btn btn-success button-add" type="button"><i class="glyphicon glyphicon-plus"></i> {{ __('Add') }}</button>
                    </div>
                  </div> --}}
                  


                <div class="form-group">
                    <a class="btn btn-danger" href="{{ route('admin.publications.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                    <button type="submit" form="publication-update-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
     @include('admin._summernote-minimal') 
    @if ( Config::get('app.locale') == 'en')
    <script>
        $('.delete__confirm').on('click', function (e) {
          e.preventDefault();
    
        //   var form = $(this).data('form-id');
        var link = this;
    
          swal({
            title: "Are you sure?",
            text: "File will be deleted.",
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
            text: "Fajl će biti obrisan.",
            icon: "warning",
            buttons: [true, 'Delete']
          }).then(function(value) {
            if (value) window.location = link.href;
          });
        })
    </script>
    @endif
<script>
@endsection
