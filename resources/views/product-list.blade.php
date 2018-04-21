@extends('layouts.admin')
@section('content')
    <h1>Список Товаров</h1>
    <a class="btn btn-primary" href="/admin/product/store-form"> Создать Товар</a>
    </br>
    </br>
    <table class="table table-bordered">
        <tr>
            <th>Название Товара</th>
            <th> Категории Товара</th>
            <th>Цена</th>
            <th>Действия</th>
        </tr>
        @foreach($product as $item)
            <tr>
                <th>{{$item['name']}}</th>
                <th> {{$item['categories_name']}} </th>
                <th>{{$item['price']}}</th>
                <th>
                    <a href="/admin/product/edit-form/{{$item['id']}}">Редактировать </a>
                    </br>
                    <a href="/admin/product/delete/{{$item['id']}}">Удалить </a>
                </th>

            </tr>
        @endforeach


    </table>
@endsection