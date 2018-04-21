@extends('layouts.admin')

@section('content')
    <h1>Список Категорий</h1>
    <a class="btn btn-primary" href="/admin/category/store-form"> Создать категорию</a>
    </br>
    </br>
    <table class="table table-bordered">
        <tr>
            <th>Название Категории</th>
            <th>Описание Категории</th>
            <th>Действия</th>
        </tr>
        @foreach($cat as $item)
            <tr>
                <th>{{$item['name']}}</th>
                <th> {{$item['description']}} </th>
                <th>
                    <a href="/admin/category/edit-form/{{$item['id']}}">Редактировать </a>
                    </br>
                    <a href="/admin/category/delete/{{$item['id']}}">Удалить </a>
                </th>

            </tr>
        @endforeach

    </table>
@endsection
