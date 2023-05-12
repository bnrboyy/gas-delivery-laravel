@extends('layouts.main-layout')

@section('sections')
    <section id="wadList">
        <div class="wadlist">
            <div class="wadlist-item">

                @include('layouts.banner-profile')

                <div class="wadlist-item-list">
                    <div class="wadlist-item-list-header">
                        <div class="wadlist-item-list-header-title">
                            <p>{{$category->cate_h1}}</p>
                            <b>{{$total_list}} {{$content_language['nv3bC1sslhJtORf']}}</b>
                        </div>
                        <div class="wadlist-item-list-header-description">
                            <p>{{$category->cate_h2}}</p>
                        </div>
                    </div>
                    <div class="wadlist-item-list-content">
                        @foreach($order_temp as $key=>$value)
                            <div class="wadlist-item-list-content-group">
                                <div class="wadlist-item-list-content-group-maingroup">
                                    <figure class="wadlist-item-list-content-group-maingroup-left">
                                        <img src="/img/wash&drylist/washing.png" alt="washingIcon" />
                                    </figure>
                                    <div class="wadlist-item-list-content-group-maingroup-right">
                                        <div class="wadlist-item-list-content-group-maingroup-right-title">
                                            <p>{{$content_language['qdXfwhf2HWyorZx']}}</p>
                                            <figure onclick='removeFromCart("{{$value[0]->orders_number}}","{{$value[0]->page_id}}","{{$value[0]->cart_number}}")'>
                                                <img src="/img/wash&drylist/drop.png" alt="dropIcon" />
                                            </figure>
                                        </div>
                                        <div class="wadlist-item-list-content-group-maingroup-right-description">
                                            <p>{{$value[0]->title}}</p>
                                            <b>{{$value[0]->totalPrice}} {{$currency_symbol}}</b>
                                        </div>
                                    </div>
                                </div>
                                @if(isset($value[1]))
                                    <div class="wadlist-item-list-content-group-subgroup">
                                        <figure class="wadlist-item-list-content-group-subgroup-left">
                                            <img src="/img/wash&drylist/drying.png" alt="dryingIcon" />
                                        </figure>
                                        <div class="wadlist-item-list-content-group-subgroup-right">
                                            <div class="wadlist-item-list-content-group-subgroup-right-title">
                                                <p>{{$content_language['1nbuWBfbhmnP9pp']}}</p>
                                                <figure onclick='removeFromCart("{{$value[1]->orders_number}}","{{$value[1]->page_id}}","{{$value[1]->cart_number}}")'>
                                                    <img src="/img/wash&drylist/drop.png" alt="dropIcon" />
                                                </figure>
                                            </div>
                                            <div class="wadlist-item-list-content-group-subgroup-right-description">
                                                <p>Drying, {{$value[1]->title}}, {{$value[1]->default_minutes + $value[1]->minutes_add}} minutes</p>
                                                <b>{{$value[1]->totalPrice}} {{$currency_symbol}}</b>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="wadlist-item-list-content-group-detail">
                                    <p>{{$content_language['zXzllHCdt8Yf88l']}} {{$value[0]->details}}</p>
                                </div>
                                <div class="wadlist-item-list-content-group-line"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="wadlist-item-button">
                        <div class="wadlist-item-button-receipt">
                            <div class="wadlist-item-button-receipt-title">
                                <div class="wadlist-item-button-receipt-title-left">
                                    <p>{{$content_language['7cRkAf4XU4Ntfml']}}</p>
                                </div>
                                <div class="wadlist-item-button-receipt-title-right">
                                    <p>{{$total_price}} {{$currency_symbol}}</p>
                                </div>
                            </div>
                            <div class="wadlist-item-button-receipt-description">
                                <p>Discounts and shipping are not included.</p>
                            </div>
                        </div>
                        <div class="wadlist-item-button-action">
                            <button type="button" onclick="wadPage()">
                                <figure>
                                    <img src="/img/wash&drylist/plus.png" alt="plusIcon" />
                                    <p>{{$content_language['DKRaKGXtC0KH8GS']}}</p>
                                </figure>
                            </button>
                            <button type="button" onclick="ordersumPage()">
                                <p>{{$content_language['LqAJbHs4BBPdMKq']}}</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/washing/cart.js"></script>
@endsection
