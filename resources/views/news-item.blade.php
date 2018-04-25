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
                        <input type="text" class="search-container__form__input" name="search">
                        <button class="search-container__form__btn">search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="content-main__container">
            <div class="news-block content-text">
                <h3 class="content-text__title">
                   {{$news['header']}}
                </h3><img src="/img/news/{{$news['photo']}}" alt="Image" class="alignleft img-news">
                <p>
                    {{$news['content']}}
                </p>
            </div>
        </div>
    </div>
    <div class="content-bottom">
        <div class="line"></div>
        <div class="content-head__container">
            <div class="content-head__title-wrap">
                <div class="content-head__title-wrap__title bcg-title">Посмотрите наши товары</div>
            </div>
        </div>
        <div class="content-main__container">
            <div class="products-columns">
                @foreach($our_goods as $item)
                    <div class="products-columns__item">
                        <div class="products-columns__item__title-product">
                            <a href="/product/{{$item['id']}}" class="products-columns__item__title-product__link">{{$item['name']}}</a>
                        </div>
                        <div class="products-columns__item__thumbnail">
                            <a href="/product/{{$item['id']}}" class="products-columns__item__thumbnail__link"><img src="/img/cover/{{$item['photo']}}" alt="Preview-image" class="products-columns__item__thumbnail__img"></a>
                        </div>
                        <div class="products-columns__item__description">
                            <span class="products-price">{{$item['price']}} руб</span>
                            @if( $login)
                                <a href="/product/{{$item['id']}}" class="btn btn-blue">Купить</a>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection