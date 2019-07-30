@extends('layouts.admin')

@section('title')
<i class="fas fa-bookmark"></i> {{__('Library')}}
@endsection

@section('subtitle')
    {{__('Create')}}
@endsection

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form id="events-create-form" action="{{ route('admin.library.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group required">
                    <label for="question">{{ __('Title') }}</label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}">
                    @if ($errors->has('title'))
                        <div class="text-danger">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                </div>

                 <div class="form-group">
                    <label class="form-check-label" for="active">{{ __('Active') }}&nbsp;</label>
                    <input type="checkbox" name="active" class="form-check-input" {{ (! empty(old('active')) ? 'checked' : '') }}>
                </div> 
                
                <div class="form-group required">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea name="description" id="editor" rows="5" class="form-control">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <div class="text-danger">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>


                <div class="form-group required">
                    <label for="images">{{__('File')}}</label>
                </div>

                {{--  <div>  --}}
                    <div class="form-group" >
                      <input type="file" name="file">
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
                    <a class="btn btn-danger" href="{{ route('admin.libraries.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                    <button type="submit" form="events-create-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
     @include('admin._summernote-minimal') 
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
