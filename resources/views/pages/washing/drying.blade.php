@extends('layouts.main-layout')

@section('sections')
    <section id="drying">
        <div class="drying">
            <div class="drying-item">

                @include('layouts.banner-profile')

                <div class="drying-item-capacity">
                    <div class="drying-item-capacity-title">
                        <p>{{ $capacityTitle->title }}</p>
                    </div>
                    <div class="drying-item-capacity-description">
                        <p>{{ $capacityTitle->details }}</p>
                    </div>
                    <div class="drying-item-capacity-content">
                        @foreach ($capacity as $key => $item)
                            <div class="drying-item-capacity-content-group {{ $key === 0 ? 'active' : '' }}"
                                data-id="{{ $item->id }}">
                                <figure class="drying-item-capacity-content-group-pick">
                                    <img src="/img/drying/pick.png" alt="pickIcon" />
                                </figure>
                                <figure class="drying-item-capacity-content-group-icon">
                                    <img src="/{{ $item->thumbnail_link }}" alt="{{ $item->thumbnail_alt }}">
                                </figure>
                                <p>{{ $item->title }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="drying-item-time">
                    <div class="drying-item-time-bg">
                        <div class="drying-item-time-bg-header">
                            <div class="drying-item-time-bg-header-title">
                                <p>{{ $dryingTimeTitle->title }}</p>
                            </div>
                            <div class="drying-item-time-bg-header-description">
                                <p>{{ $dryingTimeTitle->details }}</p>
                            </div>
                        </div>
                        <div class="drying-item-time-bg-content">
                            <div class="drying-item-time-bg-content-group">
                                <div class="drying-item-time-bg-content-group-title">
                                    <p>{{$content_language['pzrKgXNCLcVWh23']}}</p>
                                </div>
                                <div class="drying-item-time-bg-content-group-box">
                                    <div class="drying-time drying-item-time-bg-content-group-box-1 active"
                                        price-per-minutes="{{ $capacity[0]->price_per_minutes }}"
                                        round-minutes="{{ $capacity[0]->round_minutes }}"
                                        price-capacity="{{ $capacity[0]->price }}"
                                        default-minutes="{{ $capacity[0]->default_minutes }}"
                                        style="display: flex;">
                                        <figure class="drying-item-time-bg-content-group-box-1-pick">
                                            <img src="/img/drying/pick.png" alt="pickIcon" />
                                        </figure>
                                        <figure class="drying-item-time-bg-content-group-box-1-time">
                                            <img src="/img/drying/time.png" alt="timeIcon" />
                                        </figure>
                                        <div class="drying-time-title drying-item-time-bg-content-group-box-1-title">
                                            <p>{{ $capacity[0]->default_minutes }} minutes</p>
                                        </div>
                                        <div class="drying-time-description drying-item-time-bg-content-group-box-1-description">
                                            <p>{{ $capacity[0]->price }} {{$currency_symbol}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="drying-item-time-bg-content-specialgroup">
                                <div class="drying-item-time-bg-content-specialgroup-title">
                                    <p>{{$content_language['ITrjjm7W4nknVDM']}}</p>
                                </div>
                                <div class="drying-item-time-bg-content-specialgroup-box">
                                    <div class="drying-item-time-bg-content-specialgroup-box-left">
                                        <button onclick="minusTime()" type="button">
                                            <figure>
                                                <img src="/img/drying/minus.png" alt="minusIcon" />
                                            </figure>
                                        </button>
                                        <div class="drying-item-time-bg-content-specialgroup-box-left-minute">
                                            <div class="drying-item-time-bg-content-specialgroup-box-left-minute-title">
                                                <p>{{$content_language['oLhGryWeJeSpKtP']}}</p>
                                            </div>
                                            <div class="drying-item-time-bg-content-specialgroup-box-left-minute-number">
                                                <p id="minute">0</p>
                                            </div>
                                        </div>
                                        <button onclick="plusTime()" type="button">
                                            <figure>
                                                <img src="/img/drying/plus.png" alt="plusIcon" />
                                            </figure>
                                        </button>
                                    </div>
                                    <div class="drying-item-time-bg-content-specialgroup-box-right">
                                        <div class="drying-item-time-bg-content-specialgroup-box-right-price">
                                            <p>{{$content_language['NLUeqe1kH1RvHcW']}}</p>
                                            <b id="price_add_dry">0</b>
                                            <p>{{$currency_symbol}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="drying-item-time-bg-action">
                            <p onclick="resetTime()">{{$content_language['DCPa4kNnQhSoHIO']}}</p>
                            <button type="button" onclick="confirmAddMin()">{{$content_language['zU2rZkz1XOoKRvU']}}</button>
                        </div>
                    </div>
                </div>
                <div class="drying-item-button">
                    <div class="drying-item-button-receipt">
                        <div class="drying-item-button-receipt-title">
                            <div class="drying-item-button-receipt-title-left">
                                <figure>
                                    <img src="/img/drying/bottonicon.png" alt="buttonIcon" />
                                </figure>
                                <p>Washing</p>
                            </div>
                            <div class="drying-item-button-receipt-title-right">
                                <p>{{$total_price}} {{$currency_symbol}}</p>
                            </div>
                        </div>
                        <div class="drying-item-button-receipt-description">
                            <p>Previously selected item</p>
                        </div>
                    </div>
                    <div class="drying-item-button-action">
                        <button type="button" onclick="wadlistPage()">
                            <figure>
                                <img src="/img/drying/btnicon1.png" alt="buttonIcon1" />
                                {{$total_list}}
                            </figure>
                            <p>|</p>
                            <p>{{$total_price}} {{$currency_symbol}}</p>
                        </button>
                        <button onclick="saveWashing('/washing/cart')" type="button" class="add-to-cart">
                            <figure>
                                <img src="/img/drying/btnicon2.png" alt="buttonIcon2" />
                                {{$content_language['NWpO8HctXGl4pRo']}}
                            </figure>
                            <p>0 {{$currency_symbol}}</p>
                        </button>
                    </div>
                    <input id="currency" type="hidden" name="" value="{{$currency_symbol}}">
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/washing/drying.js"></script>
@endsection
