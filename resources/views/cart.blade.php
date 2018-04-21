@extends('layouts.main')

@section('content')
    <div class="content-middle">
        <div class="content-head__container">
            <div class="content-head__title-wrap">
                <div class="content-head__title-wrap__title bcg-title">Мои заказы</div>
            </div>
            <div class="content-head__search-block">
                <div class="search-container">
                    <form class="search-container__form">
                        <input type="text" class="search-container__form__input">
                        <button class="search-container__form__btn">search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="cart-product-list">
            @foreach($orders as $item)
                <div class="cart-product-list__item">
                    <div class="cart-product__item__product-photo">
                        <img src="/img/cover/{{$item['photo']}}" class="cart-product__item__product-photo__image">
                    </div>
                    <div class="cart-product__item__product-name">
                        <div class="cart-product__item__product-name__content"><a href="#">{{$item['name']}}</a></div>
                    </div>
                    <div class="cart-product__item__cart-date">
                        <div class="cart-product__item__cart-date__content">{{$item['date']}}</div>
                    </div>
                    <div class="cart-product__item__product-price"><span class="product-price__value">{{$item['price']}} рублей</span></div>
                </div>
            @endforeach

            <div class="cart-product-list__result-item">
                <div class="cart-product-list__result-item__text">Итого</div>
                <div class="cart-product-list__result-item__value">{{$sum}} рублей</div>
            </div>
        </div>
        <div class="content-footer__container">
            <div class="btn-buy-wrap"><a href="/orders/confirm" class="btn-buy-wrap__btn-link">Перейти к оплате</a></div>
        </div>
        @if(Session::has('message'))
           <div class="mail">
               {{Session::get('message')}}
           </div>
        @endif
    </div>
@endsection