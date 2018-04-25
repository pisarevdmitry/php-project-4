@extends('layouts.main')

@section('content')
    <div class="content-middle">
        <div class="content-head__container">
            <div class="content-head__title-wrap">
                <div class="content-head__title-wrap__title bcg-title">Новости</div>
            </div>
            <div class="content-head__search-block">
                <div class="search-container">
                    <form class="search-container__form" action="/search/news" method="get">
                        <input type="text" class="search-container__form__input"  name="search">
                        <button class="search-container__form__btn">search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="content-main__container">
            <div class="news-list__container">
                @foreach($news as $item)
                    <div class="news-list__item">
                        <div class="news-list__item__thumbnail"><img src="/img/news/{{$item['photo']}}"></div>
                        <div class="news-list__item__content">
                            <div class="news-list__item__content__news-title">{{$item['header']}}</div>
                            <div class="news-list__item__content__news-date">{{$item['date']}}</div>
                            <div class="news-list__item__content__news-content">
                                {{$item['exerp']}}
                            </div>
                        </div>
                        <div class="news-list__item__content__news-btn-wrap">
                            <a href="/news/article/{{$item['id']}}" class="btn btn-brown">Подробнее</a>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
@endsection