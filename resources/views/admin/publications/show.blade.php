@extends('layouts.admin') 
@section('title')
<i class="fas fa-book"></i> {{ __('Publication') }}
@endsection
 
@section('subtitle')
    {{__('View')}}
@endsection
@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="block block-rounded block-bordered">
        <div class="block-content">

                <div class="form-group">
                    {{__('Title')}}
                </div>

                <div class="form-group">
                    <h3>{{ $publication->title }}</h3>
                </div>

                <div class="form-group">
                    <label for="body">{{ __('Description') }}</label>
                </div>
                <div class="form-group">
                    <div>{!! $publication->description !!}</div>
                </div>

                <div class="form-group">
                    <label for="images">{{__('File')}}</label>
                </div>
                <div class="row">
                @if ($publication->file()->exists())
                
                <div class="col-md-4 image-edit">
                    @if (in_array(pathinfo($publication->file->filename, PATHINFO_EXTENSION),['pdf','doc','docx','zip','pptx']))
                    <div class="form-group">
                        <embed src="{{asset('uploads/publications/documents.png')}}" height="100">
                    </div>
                    @else
                    <div class="form-group">
                        <img src="{{asset('uploads/publications/' . $publication->file->filename)}}" height="100">
                    </div>
                    @endif
                    <p><a href="{{ asset('/uploads/publications/'.$publication->file->filename)}}" title="{{__('Download File')}}" download><i class="fas fa-download fa-2x"></i></a></p>
                {{-- <p><a href="{{ asset('/uploads/publications/'.$publication->file->filename)}}" title="{{__('Download File')}}" download>{{ substr($publication->file->filename, strpos($publication->file->filename, "_") + 1) }}</a></p> --}}
                </div>
                
                @endif
                </div>



                <div class="form-group">
                    <a class="btn btn-info" href="{{ route('admin.publications.index') }}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
                </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @include('admin._summernote')
@endsection