@extends('layouts.main-layout')

@section('sections')
    <section id="orderList">
        <div class="orderlist" style="min-height: 100vh;">
            <div class="orderlist-item">
                <div class="orderlist-item-profile">
                    <div class="orderlist-item-profile-frame" style="overflow:hidden;">
                        <figure class="orderlist-item-profile-frame-image">
                            <img src="/{{ isset($member->profile_image) ? $member->profile_image : 'img/profile/usericon.png' }}"
                                alt="userIcon" style="{{ isset($member->profile_image) ? 'height:100%;' : '' }}" />
                        </figure>
                    </div>
                    <div class="orderlist-item-profile-top">
                        <div class="orderlist-item-profile-top-date">
                            <p>{!! date('d/m/Y', strtotime($member->created_at)) !!}</p>
                        </div>
                        <div class="orderlist-item-profile-top-id">
                            <p>ID : {{ $member->line_id }}</p>
                        </div>
                    </div>
                    <div class="orderlist-item-profile-bottom">
                        <div class="orderlist-item-profile-bottom-notice">
                            <p>Welcome Back</p>
                        </div>
                        <div class="orderlist-item-profile-bottom-name">
                            <p>{{ $member->member_name }}</p>
                        </div>
                    </div>
                </div>
                @if (!$order)
                    <div class="orderlist-item-list">
                        <h1 class="text-center text-bold text-xl">{{$content_language['tsGd2tnPgp5sQnw']}}</h1>
                    </div>
                @else
                    @foreach ($order as $key => $value)
                        <div class="orderlist-item-list">
                            <div class="orderlist-item-list-header">
                                <div class="orderlist-item-list-header-title">
                                    <p>{{ $content_language['FARUE6MKaDcgh2g'] }}</p>
                                </div>
                                <div class="orderlist-item-list-header-description">
                                    <p>{!! date('d-m-Y', strtotime($value->transaction_date)) !!}</p>
                                </div>
                            </div>
                            @if ($value->status_name == 'complete')
                                <div class="orderlist-item-list-group">
                                    <figure class="orderlist-item-list-group-icon">
                                        <img src="/img/orderlist/status2.png" alt="orderStatusIcon2" />
                                    </figure>
                                    <div class="orderlist-item-list-group-content">
                                        <div class="orderlist-item-list-group-content-title">
                                            <p>{{ $content_language['eotQuhE51ZJuLnz'] }}</p>
                                        </div>
                                        <div class="orderlist-item-list-group-content-description text-green-500">
                                            <p>{{ $value->status_name }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="orderlist-item-list-group">
                                    <figure class="orderlist-item-list-group-icon">
                                        <img src="/img/orderlist/status.png" alt="orderStatusIcon" />
                                    </figure>
                                    <div class="orderlist-item-list-group-content">
                                        <div class="orderlist-item-list-group-content-title">
                                            <p>{{ $content_language['eotQuhE51ZJuLnz'] }}</p>
                                        </div>
                                        <div class="orderlist-item-list-group-content-description">
                                            <p>{{ $value->status_name }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="orderlist-item-list-line"></div>
                            <div class="orderlist-item-list-group">
                                <figure class="orderlist-item-list-group-icon">
                                    <img src="/img/orderlist/ordernumber.png" alt="orderNumberIcon" />
                                </figure>
                                <div class="orderlist-item-list-group-content">
                                    <div class="orderlist-item-list-group-content-title">
                                        <p>{{ $content_language['0ItP0i19dNPjRQW'] }}</p>
                                    </div>
                                    <div class="orderlist-item-list-group-content-description">
                                        <p>{{ $value->orders_number }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="orderlist-item-list-line"></div>
                            <div class="orderlist-item-list-group">
                                <figure class="orderlist-item-list-group-icon">
                                    <img src="/img/orderlist/shippingtime.png" alt="shippingTimeIcon" />
                                </figure>
                                <div class="orderlist-item-list-group-content">
                                    <div class="orderlist-item-list-group-content-title">
                                        <p>{{ $content_language['tXHgpzw9H4sZA1w'] }}</p>
                                    </div>
                                    <div class="orderlist-item-list-group-content-description">
                                        <p>Time: {{ date('h:i A', strtotime($value->shipping_date)) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="orderlist-item-list-line"></div>
                            @if ($value->type_order == 'foods')
                                <div class="orderlist-item-list-group">
                                    <figure class="orderlist-item-list-group-icon">
                                        <img src="/img/orderlist/typelist2.png" alt="typeListIcon2" />
                                    </figure>
                                    <div class="orderlist-item-list-group-content">
                                        <div class="orderlist-item-list-group-content-title">
                                            <p>{{ $content_language['411udf8l0z1YClt'] }}</p>
                                        </div>
                                        <div class="orderlist-item-list-group-content-description">
                                            <p>Vending & cafe</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($value->type_order == 'washing')
                                <div class="orderlist-item-list-group">
                                    <figure class="orderlist-item-list-group-icon">
                                        <img src="/img/orderlist/typelist.png" alt="typeListIcon" />
                                    </figure>
                                    <div class="orderlist-item-list-group-content">
                                        <div class="orderlist-item-list-group-content-title">
                                            <p>{{ $content_language['411udf8l0z1YClt'] }}</p>
                                        </div>
                                        <div class="orderlist-item-list-group-content-description">
                                            <p>Wash and Dry</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="orderlist-item-list-line"></div>
                            <div class="orderlist-item-list-group">
                                <figure class="orderlist-item-list-group-icon">
                                    <img src="/img/orderlist/address.png" alt="addressIcon" />
                                </figure>
                                <div class="orderlist-item-list-group-content">
                                    <div class="orderlist-item-list-group-content-title">
                                        <p>{{ $content_language['T50shTDWtbGUrLS'] }}</p>
                                    </div>
                                    <div class="orderlist-item-list-group-content-description">
                                        <p>{{ $value->delivery_drop_address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="orderlist-item-list-line"></div>
                            <div class="orderlist-item-list-group">
                                <figure class="orderlist-item-list-group-icon">
                                    <img src="/img/orderlist/sum.png" alt="sumIcon" />
                                </figure>
                                <div class="orderlist-item-list-group-content">
                                    <div class="orderlist-item-list-group-content-title">
                                        <p>{{ $content_language['d8gSfZLQSRZyvHS'] }}</p>
                                    </div>
                                    <div class="orderlist-item-list-group-content-description">
                                        <p> {{ $value->total_price }} {{$value->currency}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="orderlist-item-list-line"></div>
                            <div class="orderlist-item-list-button">
                                <button onclick='onOrderDetail("{{ $value->orders_number }}")'>
                                    <figure>
                                        <img src="/img/orderlist/btnicon.png" alt="orderDetailIcon">
                                    </figure>
                                    {{ $content_language['ve7LTX3JrNH6W3l'] }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/profile/orderhistory.js"></script>
@endsection
