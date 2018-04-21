@extends('layouts.admin')

@section('content')
<h1>Список Заказов</h1>
    <table class="table table-bordered">
        <tr>
          <th>№ заказа</th>
          <th>Название товара</th>
          <th>Цена товара</th>
          <th>Почта покупателя</th>
        </tr>
      @foreach($orders as $item)
        <tr>
          <th>{{$item['id']}}</th>
          <th> {{$item['name']}} </th>
          <th>{{$item['price']}}</th>
          <th>{{$item['customer_email']}}</th>
        </tr>
      @endforeach
      </table>
@endsection
