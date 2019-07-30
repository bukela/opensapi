@extends('layouts.admin') 
@section('title')
<i class="fas fa-calendar-alt"></i> {{__('Event')}}
@endsection
 
@section('subtitle')
    {{__('Edit')}}
@endsection
@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form id="event-update-form" action="{{ route('admin.events.update', ['event' => $event->id]) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="form-group required">
                    <label for="question">{{ __('Title') }}</label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title', $event->title) }}">
                    @if ($errors->has('title'))
                    <div class="text-danger">
                        {{ $errors->first('title') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="active">{{ __('Active') }}&nbsp;</label>
                    <input type="checkbox" name="active" class="form-check-input" {{$event->active == 1 ? 'checked' : ''}}
                    >
                </div>

                <div class="form-group required">
                    <label for="answer">{{ __('Content') }}</label>
                    <textarea name="content" id="editor">{{ $event->content }}</textarea>
                    @if ($errors->has('content'))
                        <div class="text-danger">
                            {{ $errors->first('content') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="start_date">{{ __('Start Date') }} <i class="fas fa-calendar-alt"></i></label>
                    <div class="control">
                        <input class="date" name="start_date" type="date" value="{{ $event->start_date }}" placeholder="Start date">
                    </div>
                </div>

                <div class="form-group">
                    <label for="start_date">{{ __('End Date') }} <i class="fas fa-calendar-alt"></i></label>
                    <div class="control">
                        <input class="date" name="end_date" type="date" value="{{ $event->end_date }}" placeholder="End date">
                    </div>
                </div>

                {{--
                <div class="form-group">
                    @if ($event->flyer)
                    <img src="/{{ $event->flyer }}" height="100"> @endif
                    <label for="file">Image</label>
                    <input name="flyer" type="file" accept="image/*">
                </div> --}}
                <div class="form-group">
                    <label for="avatar">{{__('Featured Image')}}</label>
                </div>
                <div class="form-group">
                    @if($event->featured)
                    <img src="{{asset('uploads/featured/' . $event->featured)}}" height="100">
                    <a class="delete__confirm" href="{{ route('admin.events.featured', $event->id) }}" title="{{__('Delete Image')}}"><i class="fa fa-times-circle"></i></a>
                    @endif
                    <br>
                    <input name="featured" type="file" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="flyer">{{ __('Images') }}</label>
                </div>


                {{-- {{dd($event->images)}} --}} @if ($event->images()->exists()) @foreach($event->images as $image)
                <div class="col-md-4 image-edit">
                    <div class="form-group">

                        @if (pathinfo($image->filename, PATHINFO_EXTENSION) == 'pdf')
                        <img src="{{asset('img/pdf.png')}}" height="100"> @else
                        <a class="delete__confirm" href="{{ route('admin.image.destroy', $image->id) }}"><i class="fa fa-times-circle"></i></a>
                        <img src="{{asset('uploads/events/' . $image->filename)}}" height="100">
                    </div>
                </div>
                @endif @endforeach @endif {{-- <input name="flyers[]" type="file" accept="image/*" multiple> --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="clone hide">
                                <div class="control-group input-group" style="margin-top:10px">
                                    <input type="file" name="flyers[]">
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger button-remove" type="button"><i class="glyphicon glyphicon-remove"></i> {{ __('Remove') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group form-group control-group increment">
                            <input type="file" name="flyers[]">
                            <div class="input-group-btn">
                                <button class="btn btn-success button-add" type="button"><i class="glyphicon glyphicon-plus"></i> {{ __('Add') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <a class="btn btn-danger" href="{{ route('admin.events.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                        <button type="submit" form="event-update-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
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
            text: "Event image will be deleted.",
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
            text: "Slika će biti obrisana.",
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