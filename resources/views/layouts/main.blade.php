<!DOCTYPE html>
<html lang="ru">
<head>
    <title>ГеймсМаркет</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/libs.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/media.css">
    <link rel="stylesheet" href="/css/app.css">

</head>
<body>
<div class="main-wrapper">
    <header class="main-header">
        <div class="logotype-container"><a href="/" class="logotype-link"><img src="/img/logo.png" alt="Логотип"></a></div>
        <nav class="main-navigation">
            <ul class="nav-list">
                <li class="nav-list__item"><a href="/" class="nav-list__item__link">Главная</a></li>
                <li class="nav-list__item"><a href="/" class="nav-list__item__link">Мои заказы</a></li>
                <li class="nav-list__item"><a href="/news" class="nav-list__item__link">Новости</a></li>
                <li class="nav-list__item"><a href="/about" class="nav-list__item__link">О компании</a></li>
                @if($admin)
                    <li class="nav-list__item"><a href="/admin/mail" class="nav-list__item__link">Админка</a></li>
                @endif
            </ul>
        </nav>
        <div class="header-contact">
            <div class="header-contact__phone"><a  class="header-contact__phone-link">Телефон: 33-333-33</a></div>
        </div>
        <div class="header-container">
            <div class="payment-container">
                @if( $login)
                    <div class="payment-basket__status">
                        <div class="payment-basket__status__icon-block">
                            <a class="payment-basket__status__icon-block__link" href="/orders"><i class="fa fa-shopping-basket"></i>
                            </a></div>
                        <div class="payment-basket__status__basket"><span class="payment-basket__status__basket-value">{{$bucket}}</span><span class="payment-basket__status__basket-value-descr">товаров</span></div>
                    </div>
                @endif
            </div>
            <div class="authorization-block"><a href="{{ route('register') }}" class="authorization-block__link">Регистрация</a>
                @if( $login)
                    <a href="{{route('logout')}} " class="authorization-block__link">Выйти</a>
                @else
                    <a href="{{route('login')}}" class="authorization-block__link">Войти</a>
                @endif
            </div>
        </div>
    </header>
    <div class="middle">
        <div class="sidebar">
            <div class="sidebar-item">
                <div class="sidebar-item__title">Категории</div>
                <div class="sidebar-item__content">
                    <ul class="sidebar-category">
                        @foreach($cat as $categor)
                            <li class="sidebar-category__item">
                                <a href="/category/{{$categor['id']}}" class="sidebar-category__item__link">{{$categor['name']}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="sidebar-item">
                <div class="sidebar-item__title">Последние новости</div>
                <div class="sidebar-item__content">
                    <div class="sidebar-news">
                        @foreach($last_news as $news)
                            <div class="sidebar-news__item">
                                <div class="sidebar-news__item__preview-news"><img src="/img/news/{{$news['photo']}}" alt="image-new" class="sidebar-new__item__preview-new__image"></div>
                                <div class="sidebar-news__item__title-news"><a href="/news/article/{{$news['id']}}" class="sidebar-news__item__title-news__link">{{$news['header']}}</a></div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="content-top">
                <div class="content-top__text">Купить игры неборого без регистрации смс с торента, получить компкт диск, скачать Steam игры после оплаты</div>
                <div class="slider"><img src="/img/slider.png" alt="Image" class="image-main"></div>
            </div>
            @yield('content')
            <div class="content-bottom"></div>
        </div>
    </div>
    <footer class="footer">
        <div class="footer__footer-content">
            <div class="random-product-container">
                <div class="random-product-container__head">Случайный товар</div>
                <div class="random-product-container__content">
                    <div class="item-product">
                        <div class="item-product__title-product">
                            <a href="#" class="item-product__title-product__link">{{$rand_goods['name']}}</a>
                        </div>
                        <div class="item-product__thumbnail">
                            <a href="/product/{{$rand_goods['id']}}" class="item-product__thumbnail__link">
                                <img src="/img/cover/{{$rand_goods['photo']}}" alt="Preview-image" class="item-product__thumbnail__link__img">
                            </a>
                        </div>
                        <div class="item-product__description">
                            <div class="item-product__description__products-price"><span class="products-price">{{$rand_goods['price']}} руб</span></div>
                            @if( $login)
                                <div class="item-product__description__btn-block"><a href="/product/{{$rand_goods['id']}}" class="btn btn-blue">Купить</a></div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__footer-content__main-content">
                <p>
                    Интернет-магазин компьютерных игр ГЕЙМСМАРКЕТ - это
                    онлайн-магазин игр для геймеров, существующий на рынке уже 5 лет.
                    У нас широкий спектр лицензионных игр на компьютер, ключей для игр - для активации
                    и авторизации, а также карты оплаты (game-card, time-card, игровые валюты и т.д.),
                    коды продления и многое друго. Также здесь всегда можно узнать последние новости
                    из области онлайн-игр для PC. На сайте предоставлены самые востребованные и
                    актуальные товары MMORPG, приобретение которых здесь максимально удобно и,
                    что немаловажно, выгодно!
                </p>
            </div>
        </div>
        <div class="footer__social-block">
            <ul class="social-block__list bcg-social">
                <li class="social-block__list__item"><a href="#" class="social-block__list__item__link"><i class="fa fa-facebook"></i></a></li>
                <li class="social-block__list__item"><a href="#" class="social-block__list__item__link"><i class="fa fa-twitter"></i></a></li>
                <li class="social-block__list__item"><a href="#" class="social-block__list__item__link"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
    </footer>
</div>
<script src="/js/main.js"></script>
</body>
</html>