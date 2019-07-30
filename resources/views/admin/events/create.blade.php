@extends('layouts.admin')

@section('title')
    <i class="fas fa-calendar-alt"></i> {{__('Event')}}
@endsection

@section('subtitle')
    {{__('Create')}}
@endsection

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form id="events-create-form" action="{{ route('admin.events.store') }}" method="post" enctype="multipart/form-data">
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
                    <label for="answer">{{ __('Content') }}</label>
                    <textarea name="content" id="editor">{{ old('content') }}</textarea>
                    @if ($errors->has('content'))
                        <div class="text-danger">
                            {{ $errors->first('content') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="start_date">{{ __('Start Date') }} <i class="fas fa-calendar-alt"></i></label>
                    <div class="control">
                        <input class="date" name="start_date" type="date" placeholder="Start date" value="{{ old('start_date') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="start_date">{{ __('End Date') }} <i class="fas fa-calendar-alt"></i></label>
                    <div class="control">
                        <input class="date" name="end_date" type="date" placeholder="End date" value="{{ old('start_date') }}">
                    </div>
                </div>

                {{-- <div class="form-group">
                    <label for="file">Flyer</label>
                    <input name="flyers[]" type="file" accept="image/*" multiple>
                </div> --}}
                <div class="form-group">
                    <label for="featured">{{__('Featured Image')}}</label>
                </div>
                <div class="form-group">
                        <input name="featured" type="file" accept="image/*">
                        @if ($errors->has('featured'))
                            <div class="invalid-feedback text-danger">
                                {{ $errors->first('featured') }}
                            </div>
                        @endif
                </div>

                <div class="form-group">
                    <label for="images">{{__('Images')}}</label>
                </div>

                <div class="clone hide">
                    <div class="control-group input-group" style="margin-top:10px">
                      <input type="file" name="flyers[]">
                      @if ($errors->has('flyers.*'))
                        <div class="text-danger">
                            {{ $errors->first('flyers.*') }}
                        </div>
                    @endif
                      <div class="input-group-btn"> 
                        <button class="btn btn-danger button-remove" type="button"><i class="glyphicon glyphicon-remove"></i> {{ __('Remove') }}</button>
                      </div>
                    </div>
                  </div>
                <div class="input-group control-group increment" >
                    <input type="file" name="flyers[]">
                    @if ($errors->has('flyers.*'))
                        <div class="text-danger">
                            {{ $errors->first('flyers.*') }}
                        </div>
                    @endif
                    <div class="input-group-btn"> 
                      <button class="btn btn-success button-add" type="button"><i class="glyphicon glyphicon-plus"></i> {{ __('Add') }}</button>
                    </div>
                  </div>
                  


                <div class="form-group">
                    <a class="btn btn-danger" href="{{ route('admin.events.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                    <button type="submit" form="events-create-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    @include('admin._summernote')
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
