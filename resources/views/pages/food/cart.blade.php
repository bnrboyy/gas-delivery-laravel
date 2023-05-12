@extends('layouts.main-layout')

@section('sections')
    <section id="cart">

        <div class="cart">
            <div class="cart-item">
                <div class="cart-item-header">
                    <figure class="cart-item-header-icon">
                        <img src="/img/cart/headericon.png" alt="headerIcon" />
                    </figure>
                    <div class="cart-item-header-title">
                        <p>Cart</p>
                        <figure>
                            <img src="/img/cart/usericon.png" alt="userIcon" />
                        </figure>
                    </div>
                </div>
                <div class="cart-item-list">
                    <div class="cart-item-list-header">
                        <div class="cart-item-list-header-title">
                            <p>{{$content_language['SLczhvM483BnChZ']}}</p>
                            <b style="font-size: 16px;">{{$order_item[0]->orders_number}}</b>
                        </div>
                        <div class="cart-item-list-header-description">
                            <p>The choice will affect the price of using the service.</p>
                        </div>
                    </div>
                    <div class="cart-item-list-content" style="padding-bottom: 6rem;">
                        {{-- @dd($order_item) --}}
                        @foreach ($order_item as $item)
                            <div class="cart-item-list-content-group">
                                <div class="cart-item-list-content-group-left">
                                    <figure>
                                        <img src="/{{ $item->thumbnail_link }}" alt="orderImage1" />
                                    </figure>
                                </div>
                                <div class="cart-item-list-content-group-right">
                                    <div class="cart-item-list-content-group-right-top">
                                        <p>{{ $item->cate_title }}</p>
                                        <div class="cart-item-list-content-group-right-top-right">
                                            <div style="display: flex; flex-direction: column; align-items: end;">
                                                @if ($item->microwave_name)
                                                    <p>Mi: {{$item->microwave_name}}</p>
                                                @elseif($item->sweetness_name)
                                                    <p>Mi: {{$item->sweetness_name}}</p>
                                                @endif
                                            </div>
                                            <figure onclick="drop('{{$item->orders_number}}', '{{$item->product_id}}', '{{$item->cart_number}}')">
                                                <img src="/img/cart/dropicon.png" alt="dropIcon" />
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="cart-item-list-content-group-right-mid">
                                        <p>{{ $item->product_title }}</p>
                                    </div>
                                    <div class="cart-item-list-content-group-right-bot">
                                        <div class="cart-item-list-content-group-right-bot-left">
                                            <p>{{ $item->price }} {{$currency_symbol}}</p>
                                        </div>
                                        <div class="cart-item-list-content-group-right-bot-right">
                                            <figure
                                                onclick="minusQuantity('{{ $item->orders_number }}', {{ $item->product_id }},{{ $item->quantity }},{{ $item->cart_number }})">
                                                <img src="/img/cart/minus.png" alt="minusIcon" />
                                            </figure>
                                            <p class="quantity">{{ $item->quantity }}</p>
                                            <figure
                                                onclick="plusQuantity('{{ $item->orders_number }}', {{ $item->product_id }},{{ $item->quantity }},{{ $item->cart_number }})">
                                                <img src="/img/cart/plus.png" alt="plusIcon" />
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-item-list-content-line"></div>
                        @endforeach
                    </div>
                </div>
                <div class="cart-item-button">
                    <div class="cart-item-button-receipt">
                        <div class="cart-item-button-receipt-title">
                            <div class="cart-item-button-receipt-title-left">
                                <p>{{$content_language['7cRkAf4XU4Ntfml']}}</p>
                            </div>
                            <div class="cart-item-button-receipt-title-right">
                                <p>{{ $total_price }} {{$currency_symbol}}</p>
                            </div>
                        </div>
                        <div class="cart-item-button-receipt-description">
                            <p>{{$content_language['4GX41aMsumE0xYz']}}</p>
                        </div>
                    </div>
                    <div class="cart-item-button-action">
                        <button onclick="foodNdrinkPage()">
                            <figure>
                                <img src="/img/cart/btnplus.png" alt="plusIcon" />
                                <p>{{$content_language['DKRaKGXtC0KH8GS']}}</p>
                            </figure>
                        </button>
                        <button onclick="confirmCart()">
                            <p>{{$content_language['LqAJbHs4BBPdMKq']}}</p>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/foods/cart.js"></script>
@endsection
