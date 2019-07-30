@extends('layouts.admin') 
@section('title')
<i class="fas fa-newspaper"></i> {{__('News')}}
@endsection
@section('subtitle')
    {{__('Edit')}}
@endsection
@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form id="news-update-form" action="{{ route('admin.news.update', ['news' => $news->id]) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="form-group required">
                    <label for="question">{{ __('Title') }}</label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $news->title }}">                    @if ($errors->has('title'))
                    <div class="text-danger">
                        {{ $errors->first('title') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="question">{{ __('Active') }}&nbsp;</label>
                    <input type="checkbox" name="active" class="form-check-input" {{$news->active == 1 ? 'checked' : ''}}
                    >
                </div>

                <div class="form-group required">
                    <label for="body">{{ __('Content') }}</label>
                    <textarea name="body" id="editor">{{ $news->body }}</textarea>
                    @if ($errors->has('body'))
                            <div class="text-danger invalid-feedback">
                                {{ $errors->first('body') }}
                            </div>
                        @endif
                </div>

                {{--
                <div class="form-group">
                    @if ($news->image()->exists())
                    <a class="delete__confirm" href="{{ route('admin.newsimage.destroy', $news->image->id) }}"><i class="fa fa-times-circle"></i></a>
                    <img src="{{asset('uploads/news/' . $news->image->filename)}}" height="100"> @endif
                    <label for="file">{{ __('Image') }}</label>
                    <input name="file" type="file" accept="image/*">
                </div> --}}

                <div class="form-group">
                    <label for="featured">{{__('Featured Image')}}</label>
                </div>

                <div class="form-group">
                    @if($news->featured)
                    <img src="{{asset('uploads/featured/' . $news->featured)}}" height="100">
                    <a class="delete__confirm" href="{{ route('admin.news.featured', $news->id) }}" title="{{__('Delete Image')}}"><i class="fa fa-times-circle"></i></a>
                    @endif
                    <input name="featured" type="file" accept="image/*">
                    @if ($errors->has('featured'))
                            <div class="invalid-feedback text-danger">
                                {{ $errors->first('featured') }}
                            </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="flyer">{{ __('File') }}</label>
                </div>


                {{-- {{dd($event->images)}} --}} @if ($news->images()->exists()) @foreach($news->images as $image)
                <div class="col-md-4 image-edit">
                    <div class="form-group">
                        @if (pathinfo($image->filename, PATHINFO_EXTENSION) == 'pdf')
                        <img src="{{asset('img/pdf.png')}}" height="100"> @else
                        <a class="delete__confirm" href="{{ route('admin.image.destroy', $image->id) }}"><i class="fa fa-times-circle"></i></a>
                        <img src="{{asset('uploads/news/' . $image->filename)}}" height="100">
                    </div>
                </div>
                @endif @endforeach @endif {{-- <input name="flyers[]" type="file" accept="image/*" multiple> --}}
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="form-group">
                            <div class="clone hide">
                                <div class="control-group input-group" style="margin-top:10px">
                                    <input type="file" name="flyers[]">
                                    @if ($errors->has('flyers.*'))
                                        <div class="invalid-feedback text-danger">
                                        {{ $errors->first('flyers.*') }}
                                    </div>
                                    @endif
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger button-remove" type="button"><i class="glyphicon glyphicon-remove"></i> {{ __('Remove') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group form-group control-group increment">
                            <input type="file" name="flyers[]">
                            @if ($errors->has('flyers.*'))
                            <div class="invalid-feedback text-danger">
                                {{ $errors->first('flyers.*') }}
                            </div>
                            @endif
                            <div class="input-group-btn">
                                <button class="btn btn-success button-add" type="button"><i class="glyphicon glyphicon-plus"></i> {{ __('Add') }}</button>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <a class="btn btn-danger" href="{{ route('admin.news.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                    <button type="submit" form="news-update-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
() 
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