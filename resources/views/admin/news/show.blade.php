@extends('layouts.admin') 
@section('title')
<i class="fas fa-newspaper"></i> {{ __('News') }}
@endsection
 
@section('subtitle')
    {{__('View')}}
@endsection
@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form id="news-update-form" action="{{ route('admin.news.update', ['news' => $news->id]) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('PATCH') }}

                <div class="form-group">
                    {{__('Title')}}
                </div>

                <div class="form-group">
                    <h1>{{ $news->title }}</h1>
                </div>

                <div class="form-group">
                    <label for="body">{{ __('Content') }}</label>
                </div>
                <div class="form-group">
                    <div>{!! $news->body !!}</div>
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
                    <img src="{{asset('uploads/featured/' . $news->featured)}}" height="100" alt="news-featured">
                    @endif
                </div>

                <div class="form-group">
                    <label for="images">Images</label>
                </div>
                <div class="row">
                @if ($news->images()->exists())
                @foreach($news->images as $image)
                <div class="col-md-4 image-edit">
                    <div class="form-group">
                        <img src="{{asset('uploads/news/' . $image->filename)}}" height="100">
                    </div>
                </div>
                @endforeach
                @endif
                </div>



                <div class="form-group">
                    <a class="btn btn-info" href="{{ route('admin.news.index') }}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    @include('admin._summernote')
@endsection