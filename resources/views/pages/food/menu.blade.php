@extends('layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="/css/foods-menu.css" />
@endsection

@section('sections')
    <section id="food">
        <div class="food">
            <div class="food-item">
                <div class="food-item-header">
                    <figure class="food-item-header-icon">
                        <img src="/img/food/headericon.png" alt="wash&DryIcon" />
                    </figure>
                    <div class="food-item-header-title">
                        <p>{{$category->title}}</p>
                        <figure>
                            <img src="/img/food/usericon.png" alt="userIcon" />
                        </figure>
                    </div>
                </div>
                <div class="food-item-category">
                    <div class="food-item-category-title">
                        <p>{{$content_language['gcQtJs1mG7LpSH9']}}</p>
                    </div>
                    <div class="food-item-category-search">
                        <figure>
                            <img src="/img/food/searchicon.png" alt="searchIcon" />
                        </figure>
                        <input id="search" type="text" placeholder="Search" />
                    </div>
                    <div class="food-item-category-list">
                        @foreach ($product_cate as $pcat)
                        <div class="food-item-category-list-box" cate-id="{{$pcat->id}}">
                            <figure>
                                <img src="/{{$pcat->thumbnail_link}}" alt="snackIcon" />
                            </figure>
                            <p>{{$pcat->title}}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="food-item-category-dish">
                        @foreach ($foodNDrink as $food)
                        <div class="food-item-category-dish-box" dish-id="{{$food->id}}">
                            <figure>
                                <img src="/{{$food->thumbnail_link}}" alt="dishImage1" />
                            </figure>
                            <p>{{$food->title}}</p>
                            <b>{{$food->price}} {{$currency_symbol}}</b>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="food-item-button">
                    <button onclick="cartPage()" class="food-item-button-content">
                        <div class="food-item-button-content-left">
                            <figure>
                                <img src="/img/food/carticon.png" alt="cartIcon" />
                            </figure>
                            <p>{{$total_list}}</p>
                        </div>
                        <div class="food-item-button-content-right">
                            <p>{{$content_language['yC2SXD73c5EJdak']}}</p>
                            <b>{{$total_price}} {{$currency_symbol}}</b>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/foods/menu.js"></script>
@endsection
