@extends('layouts.admin')

@section('content')
    <h1>Список Новостей</h1>
    <a class="btn btn-primary" href="/admin/news/store-form"> Создать Новость</a>
    </br>
    </br>
    <table class="table table-bordered">
        <tr>
            <th>Заголовок </th>
            <th>Изображение</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
        @foreach($news as $item)
            <tr>
                <th> {{$item['header']}} </th>
                <th>
                    <img src="/img/news/{{$item['photo']}}" class="image-news">
                </th>
                <th>{{$item['date']}}</th>
                <th>
                    <a href="/admin/news/edit-form/{{$item['id']}}">Редактировать </a>
                    </br>
                    <a href="/admin/news/delete/{{$item['id']}}">Удалить </a>
                </th>
            </tr>
        @endforeach
    </table>
@endsection
