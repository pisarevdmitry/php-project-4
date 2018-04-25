@extends('layouts.main')

@section('content')
    <div class="content-middle">
        <div class="content-head__container">
            <div class="content-head__title-wrap">
                <div class="content-head__title-wrap__title bcg-title">{{$product['name']}} в разделе {{$product['categories_name']}}</div>
            </div>
            <div class="content-head__search-block">
                <div class="search-container">
                    <form class="search-container__form" action="/search/goods" method="get">
                        <input type="text" class="search-container__form__input" name="search">
                        <button class="search-container__form__btn">search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="content-main__container">
            <div class="product-container">
                <div class="product-container__image-wrap"><img src="/img/cover/{{$product['photo']}}" class="image-wrap__image-product"></div>
                <div class="product-container__content-text">
                    <div class="product-container__content-text__title">{{$product['name']}}</div>
                    <div class="product-container__content-text__price">
                        <div class="product-container__content-text__price__value">
                            Цена: <b>{{$product['price']}}</b>
                            руб
                        </div>
                        @if( $login)
                            <a href="#" class="btn btn-blue button-buy">Купить</a>
                        @endif
                    </div>
                    <div class="product-container__content-text__description">
                        <p>
                            {{$product['description']}}
                        </p>

                    </div>
                </div>
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
                                <a href="/product/{{$item['id']}}" class="btn btn-blue button-buy">Купить</a>
                            @endif

                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <form method="POST" action="" class="form-show form-hide" enctype="application/x-www-form-urlencoded">
        @csrf

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Имя') }}</label>

            <div class="col-md-4">
                <input id="name" type="text" class="form-control" name="name" required >

            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Почта') }}</label>

            <div class="col-md-4">
                <input id="email" type="email" class="form-control"
                       name="email" value="{{ $email }}">

            </div>
        </div>
        <input  type="hidden" name="id" value="{{ $product['id'] }}">
        <input  type="hidden" name="customer" value="{{ $id }}">
        <div class="message">
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Отправить заявку') }}
                </button>
                <a  class="btn btn-secondary button-close">
                    {{ __('Закрыть') }}
                </a>
            </div>
        </div>

    <form>
@endsection