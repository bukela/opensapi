@extends('layouts.admin') 
@section('title')
<i class="fa fa-images"></i> {{__('Gallery')}}
@endsection
 

@section('content')
<div class="panel panel-default">
        <div class="panel-heading text-center">
        <h3>{{ $gallery->title }}</h3>
        </div>
        <div class="panel-body">
        <span>{!! $gallery->description !!}</span>
        <div class="row">
                <div class="col-md-12 text-center">
                    @foreach ($gallery->slides as $slide)
                        <div class="col-md-4">
                        <img class="gallery-slide" src="{{ asset('/uploads/galleries/'.$slide->filename) }}" alt="{{ $slide->filename }}">
                        </div>
                    @endforeach
                </div>
        </div>
        </div>
</div>
@endsection

@section('css')
    <style>
        .gallery-slide {
            width: 200px;
            height: 200px;
            margin-bottom: 10px;
            object-fit: cover;
        }
    </style>
@endsection