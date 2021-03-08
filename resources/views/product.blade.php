@extends('layouts.master')


@section('title', 'Товар')

@section('content')
    

    
                              <h1>{{ $product->name }}</h1>
    <h2>{{ $product->category->name }}</h2>
    <p>Цена: <b>{{ $product->price }} ₽</b></p>
    <img height="400px" src="{{Storage::url($product->image)}}">
    <p>{{ $product->description  }}</p>

            <form action="{{ route('basket-add',$product) }}" method="POST">
                @csrf
                @if ($product->isAvailable())
                
                <button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>
                @else Товар не доступен
                @endif

                   </form>
        
         @endsection