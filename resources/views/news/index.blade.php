@extends('layouts.app')

@section('content')
    <div class="news-section">
        <div class="offset-xl-2 col-xl-8 offset-lg-1 col-lg-10 ">
            <div class="news__block">
                    <h1 class="press-header">My Respects Press</h1>
                <div class="news__items">
                    @foreach($news as $item)
                        <div class="single-news news__item">
                            <div class="row">
                                @if ($item->image()->exists())
                                <div class="col-lg-5 col-sm-10">
                                        <img src="{{asset('uploads/press/' . $item->image->filename)}}"
                                             style="margin-bottom: 5px">
                                </div>
                                @endif

                                @php $col = $item->image()->exists() ? '7' : '12'; @endphp

                                <div class="col-lg-{{ $col }} col-sm-10">
                                    <div class="single-news__text">
                                        <h2>
                                            {{ $item->title }}
                                        </h2>
                                        <p>@php $body = $item->body @endphp
                                        {!! str_limit($body, 300) !!}</p>
                                    </div>
                                    <div class="read-more__link">
                                        <a href="{{ route('news.show', ['news' => $item->slug]) }}">Read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($news->hasMorePages())
                    <div class="col-lg-12">
                        <div class="more-button">
                            <button class="load_more_button">More</button>
                        </div>
                    </div>
                    <div style="display: none;">{{ $news->links('vendor.pagination.bootstrap-4') }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    @if ($news->hasMorePages())
        <script>
          $( document ).ready(function() {
            $('.news__items').infiniteScroll({
              path: '.pagination li.active + li a',
              append: '.news__item',
              prefil: true,
              history: false,
              hideNav: '.pagination',
              scrollThreshold: false,
              button: '.load_more_button'
            })
          })
        </script>
    @endif
@endsection
