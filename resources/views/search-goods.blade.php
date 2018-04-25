@extends('layouts.main')

@section('content')
    <div class="content-middle">
        <div class="content-head__container">
            <div class="content-head__title-wrap">
                <div class="content-head__title-wrap__title bcg-title">Результаты поиска</div>
            </div>
            <div class="content-head__search-block">
                <div class="search-container">
                    <form class="search-container__form" action="/search/{{$type}}" method="get">
                        <input type="text" class="search-container__form__input" name="search">
                        <button class="search-container__form__btn">search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="content-main__container">
            <div class="products-columns">
                @foreach($search as $item)
                    <div class="products-columns__item">
                        <div class="products-columns__item__title-product">
                            @if ($item['type'] === 'product' )
                                <a href="/product/{{$item['id']}}" class="products-columns__item__title-product__link">{{$item['name']}}</a>
                            @else
                                <a href="/news/article/{{$item['id']}}" class="products-columns__item__title-product__link">{{$item['name']}}</a>
                            @endif
                        </div>
                        <div class="products-columns__item__thumbnail">
                            @if ($item['type'] === 'product' )
                                <a href="/product/{{$item['id']}}" class="products-columns__item__thumbnail__link">
                                    <img src="/img/cover/{{$item['photo']}}" alt="Preview-image" class="products-columns__item__thumbnail__img">
                                </a>
                        </div>
                        <div class="products-columns__item__description">
                            <span class="products-price">{{$item['price']}} руб</span>
                        </div>
                            @if( $login)
                                <a href="/product/{{$item['id']}}" class="btn btn-blue">Купить</a>
                            @endif
                            @else
                                <a href="/news/article/{{$item['id']}}" class="products-columns__item__thumbnail__link">
                                    <img src="img/news/{{$item['photo']}}" alt="Preview-image" class="products-columns__item__thumbnail__img">
                                </a>
                            @endif
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