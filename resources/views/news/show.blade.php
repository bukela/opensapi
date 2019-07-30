@extends('layouts.app')

@section('content')
    <div class="news-section">
        <div class="offset-xl-2 col-xl-8 offset-lg-1 col-lg-10">
            <div class="news__block">
                <h1>{{ $news->title }}</h1>
                <div class="single-news__details">
                    <div class="row">
                        @if ($news->image()->exists())
                        <div class="col-lg-4">
                                <img src="{{asset('uploads/press/' . $news->image->filename)}}"
                                     style="margin-bottom: 5px">
                        </div>
                        @endif

                        @php $col = $news->image()->exists() ? '7' : '12'; @endphp

                        <div class="col-lg-{{ $col }}">
                            <div class="single-news__text">
                            <p>{!! $news->body !!}</p>
                            </div>
                            <div class="read-more__link">
                                <a onclick="window.history.back()">Go back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
