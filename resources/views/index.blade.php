@extends('layouts.main')

@section('content')
<div class="content-middle">
    <div class="content-head__container">
        <div class="content-head__title-wrap">
            <div class="content-head__title-wrap__title bcg-title">Последние товары</div>
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
    <div class="content-main__container">
        <div class="products-columns">
            @foreach($goods as $item)
                <div class="products-columns__item">
                    <div class="products-columns__item__title-product">
                        <a href="/product/{{$item['id']}}" class="products-columns__item__title-product__link">{{$item['name']}}</a>
                    </div>
                    <div class="products-columns__item__thumbnail">
                        <a href="/product/{{$item['id']}}" class="products-columns__item__thumbnail__link">
                            <img src="img/cover/{{$item['photo']}}" alt="Preview-image" class="products-columns__item__thumbnail__img">
                        </a>
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
    <div class="content-footer__container">
        <ul class="page-nav">
            <li class="page-nav__item"><a href="/?page={{$current_page-1}}" class="page-nav__item__link"><i class="fa fa-angle-double-left"></i></a></li>
            @for($i=1; $i <= $count; $i++)
                <li class="page-nav__item"><a href="/?page={{$i}}" class="page-nav__item__link">{{$i}}</a></li>
            @endfor
            <li class="page-nav__item"><a href="/?page={{$current_page+1}}" class="page-nav__item__link"><i class="fa fa-angle-double-right"></i></a></li>
        </ul>
    </div>
</div>
@endsection