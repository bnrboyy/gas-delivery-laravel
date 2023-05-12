@extends('layouts.main-layout')

@section('sections')
    <section id="orderDetail">

        <div class="orderdetail">
            <div class="orderdetail-item">

                @include('layouts.banner')

                <div class="orderdetail-item-list">
                    <div class="orderdetail-item-list-header">
                        <div class="orderdetail-item-list-header-title">
                            <p>{{$content_language['0ItP0i19dNPjRQW']}}</p>
                        </div>
                        <div class="orderdetail-item-list-header-description">
                            <p>{{ $order->orders_number }}</p>
                        </div>
                    </div>
                    @if ($order->status_name == 'complete')
                        <div class="orderlist-item-list-group">
                            <figure class="orderlist-item-list-group-icon">
                                <img src="/img/orderlist/status2.png" alt="orderStatusIcon2" />
                            </figure>
                            <div class="orderlist-item-list-group-content">
                                <div class="orderlist-item-list-group-content-title">
                                    <p>{{$content_language['eotQuhE51ZJuLnz']}}</p>
                                </div>
                                <div class="orderlist-item-list-group-content-description text-green-500">
                                    <p>{{ $order->status_name }}</p>
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
                                    <p>{{$content_language['eotQuhE51ZJuLnz']}}</p>
                                </div>
                                <div class="orderlist-item-list-group-content-description">
                                    <p>{{ $order->status_name }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="orderdetail-item-list-line"></div>
                    <div class="orderdetail-item-list-group">
                        <figure class="orderdetail-item-list-group-icon">
                            <img src="/img/orderdetail/date.png" alt="dateIcon" />
                        </figure>
                        <div class="orderdetail-item-list-group-content">
                            <div class="orderdetail-item-list-group-content-title">
                                <p>{{$content_language['FARUE6MKaDcgh2g']}}</p>
                            </div>
                            <div class="orderdetail-item-list-group-content-description">
                                <p>{{ date('d-m-Y', strtotime($order->transaction_date)) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="orderdetail-item-list-line"></div>
                    <div class="orderdetail-item-list-group">
                        <figure class="orderdetail-item-list-group-icon">
                            <img src="/img/orderdetail/shippingtime.png" alt="shippingTimeIcon" />
                        </figure>
                        <div class="orderdetail-item-list-group-content">
                            <div class="orderdetail-item-list-group-content-title">
                                <p>{{$content_language['JBcoUyvEt4jKaH1']}}</p>
                            </div>
                            <div class="orderdetail-item-list-group-content-description">
                                <p>Time: {{ date('h:i A', strtotime($order->shipping_date)) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="orderdetail-item-list-line"></div>
                    <div class="orderdetail-item-list-group">
                        <figure class="orderdetail-item-list-group-icon">
                            <img src="/img/orderdetail/typelist.png" alt="typeListIcon" />
                        </figure>
                        <div class="orderdetail-item-list-group-content">
                            <div class="orderdetail-item-list-group-content-title">
                                <p>{{$content_language['411udf8l0z1YClt']}}</p>
                            </div>
                            <div class="orderdetail-item-list-group-content-description">
                                <p>Wash and Dry</p>
                            </div>
                        </div>
                    </div>
                    <div class="orderdetail-item-list-line"></div>
                    <!-- Address -->
                    <div class="orderdetail-item-list-specialgroup">
                        <figure class="orderdetail-item-list-specialgroup-icon">
                            <img id="addressIcon" src="/img/orderdetail/address.png" alt="addressIcon" />
                        </figure>
                        <div class="orderdetail-item-list-specialgroup-address">
                            <div class="orderdetail-item-list-specialgroup-address-title">
                                <p>{{$content_language['aBtjDb1h65e4rii']}}</p>
                            </div>
                            <div class="orderdetail-item-list-specialgroup-address-content">
                                <div class="orderdetail-item-list-specialgroup-address-content-title">
                                    <p>{{$content_language['5AD9NMb52XVVsp']}}</p>
                                </div>
                                <div class="orderdetail-item-list-specialgroup-address-content-description">
                                    <p>{{ $order->delivery_pickup_address }}</p>
                                </div>
                                <div class="orderdetail-item-list-specialgroup-address-content-detail">
                                    <p>{{$content_language['NEa9oYkheKKEWYm']}} : {{ $order->delivery_pickup_address_more }}</p>
                                </div>
                            </div>
                            <div class="orderdetail-item-list-specialgroup-address-line"></div>
                            <div class="orderdetail-item-list-specialgroup-address-content">
                                <div class="orderdetail-item-list-specialgroup-address-content-title">
                                    <p>{{$content_language['aWKCt5YRkrra8GW']}}</p>
                                </div>
                                <div class="orderdetail-item-list-specialgroup-address-content-description">
                                    <p>{{ $order->delivery_drop_address }}</p>
                                </div>
                                <div class="orderdetail-item-list-specialgroup-address-content-detail">
                                    <p>{{$content_language['NEa9oYkheKKEWYm']}} : {{ $order->delivery_drop_address_more }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="orderdetail-item-list-line"></div>
                    <div class="orderdetail-item-list-specialgroup">
                        <figure class="orderdetail-item-list-specialgroup-icon">
                            <img src="/img/orderdetail/pickup.png" alt="pickupIcon" />
                        </figure>
                        <div class="orderdetail-item-list-specialgroup-address">
                            <div class="orderdetail-item-list-specialgroup-address-title">
                                <p>{{$content_language['pEsIJ8yCHqKMLJt']}}</p>
                            </div>
                            <div class="orderdetail-item-list-specialgroup-address-content">
                                <div class="orderdetail-item-list-specialgroup-address-content-title">
                                    <p>{{$content_language['5AD9NMb52XVVsp']}}</p>
                                </div>
                                <div class="orderdetail-item-list-specialgroup-address-content-description">
                                    <p>{{ date('l,F j,Y', strtotime($order->date_pickup)) }}<br> Time:
                                        {{ date('h:i A', strtotime($order->date_pickup)) }}</p>
                                </div>
                            </div>
                            <div class="orderdetail-item-list-specialgroup-address-line"></div>
                            <div class="orderdetail-item-list-specialgroup-address-content">
                                <div class="orderdetail-item-list-specialgroup-address-content-title">
                                    <p>{{$content_language['GGcdV5UPmpc316c']}}</p>
                                </div>
                                <div class="orderdetail-item-list-specialgroup-address-content-description">
                                    <p>{{ date('l,F j,Y', strtotime($order->date_drop)) }}<br> Time:
                                        {{ date('h:i A', strtotime($order->date_drop)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="orderdetail-item-list-line"></div>
                    <div class="orderdetail-item-list-group">
                        <figure class="orderdetail-item-list-group-icon">
                            <img src="/img/orderdetail/phone.png" alt="phoneIcon" />
                        </figure>
                        <div class="orderdetail-item-list-group-content">
                            <div class="orderdetail-item-list-group-content-title">
                                <p>{{$content_language['7H8EKBAAbPaBOFl']}}</p>
                            </div>
                            <div class="orderdetail-item-list-group-content-description">
                                <p>{{ $order->phone_number }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="orderdetail-item-list-line"></div>
                    <div class="orderdetail-item-list-group">
                        <figure class="orderdetail-item-list-group-icon">
                            <img src="/img/orderdetail/branch.png" alt="branchIcon" />
                        </figure>
                        <div class="orderdetail-item-list-group-content">
                            <div class="orderdetail-item-list-group-content-title">
                                <p>a branch</p>
                            </div>
                            <div class="orderdetail-item-list-group-content-description">
                                <p>{{ $order->branch_name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="orderdetail-item-list-line"></div>
                    <div class="orderdetail-item-list-group">
                        <figure class="orderdetail-item-list-group-icon">
                            <img src="/img/orderdetail/payment.png" alt="paymentIcon" />
                        </figure>
                        <div class="orderdetail-item-list-group-content">
                            <div class="orderdetail-item-list-group-content-title">
                                <p>{{$content_language['kUP6dQ7fL9vPvsr']}}</p>
                            </div>
                            <div class="orderdetail-item-list-group-content-description">
                                <p>{{ $order->payment_type }}</p>
                                <figure>
                                    <a href="/profile/orderhistory/detail/receipt/{{ $order->orders_number }}"><img
                                            src="/img/orderdetail/receipt.png" alt="receiptIcon"></a>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="orderdetail-item-list-line"></div>
                    <div class="orderdetail-item-list-group">
                        <figure class="orderdetail-item-list-group-icon">
                            <img src="/img/orderdetail/camera.png" alt="camera" />
                        </figure>
                        <div class="orderdetail-item-list-group-content">
                            <div class="orderdetail-item-list-group-content-title">
                                <p>{{$content_language['ZYvWS3fZpZ8BppH']}}</p>
                            </div>
                            <div class="orderdetail-item-list-group-content-description">
                                <p>{{$content_language['P8jBIDFhq91sXyl']}}</p>
                                <figure>
                                    <a href="/profile/orderhistory/detail/evidence/{{ $order->orders_number }}"><img
                                            src="/img/orderdetail/img.png" alt="imgIcon"></a>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="orderdetail-item-list-line"></div>
                </div>
                <div class="orderdetail-item-receipt">
                    <div class="orderdetail-item-receipt-header">
                        <div class="orderdetail-item-receipt-header-title">
                            <p>{{$content_language['1rbNgqKi2Z0RbGA']}}</p>
                        </div>
                        <div class="orderdetail-item-receipt-header-description">
                            <p>{{$content_language['nrNBgmeaX4VfsCy']}}</p>
                        </div>
                    </div>

                    @foreach ($orderItems as $key => $value)
                        <div class="orderdetail-item-receipt-group">
                            <figure class="orderdetail-item-receipt-group-icon">
                                <img src="/img/orderdetail/washing.png" alt="washIcon">
                            </figure>
                            <div class="orderdetail-item-receipt-group-content">
                                <div class="orderdetail-item-receipt-group-content-title">
                                    <p>{{$content_language['1TuhDnZjqwcomUh']}}</p>
                                </div>
                                <div class="orderdetail-item-receipt-group-content-description">
                                    <p>Washing {{ $value[0]->title }} </p>
                                </div>
                                <div class="orderdetail-item-receipt-group-content-price">
                                    <p>{{ $value[0]->totalPrice }} {{$order->currency}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="orderdetail-item-receipt-line"></div>
                        @if (isset($value[1]))
                            {{-- <div class="orderdetail-item-receipt-line"></div> --}}
                            <div class="orderdetail-item-receipt-subgroup">
                                <figure class="orderdetail-item-receipt-subgroup-icon">
                                    <img src="/img/wash&drylist/drying.png" alt="washIcon">
                                </figure>
                                <div class="orderdetail-item-receipt-subgroup-content">
                                    <div class="orderdetail-item-receipt-subgroup-content-title">
                                        <p>{{$content_language['KU3VbuavKrZduwJ']}}</p>
                                    </div>
                                    <div class="orderdetail-item-receipt-subgroup-content-description">
                                        <p>Drying {{ $value[1]->title }},
                                            {{ $value[1]->default_minutes + $value[1]->minutes_add }} Minutes</p>
                                    </div>
                                    <div class="orderdetail-item-receipt-subgroup-content-price">
                                        <p>{{ $value[1]->totalPrice }} {{$order->currency}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <div class="orderdetail-item-receipt-line"></div>
                    <div class="orderdetail-item-receipt-sum">
                        <div class="orderdetail-item-receipt-sum-group">
                            <div class="orderdetail-item-receipt-sum-group-title">
                                <p>{{$content_language['PWSMvwRtaU6sSIO']}}</p>
                            </div>
                            <div class="orderdetail-item-receipt-sum-group-description">
                                <p>{{ $subTotal }} {{$order->currency}}</p>
                            </div>
                        </div>
                        <div class="orderdetail-item-receipt-sum-group">
                            <div class="orderdetail-item-receipt-sum-group-title">
                                <p>{{$content_language['qsLpFtrvkJon7yW']}}</p>
                            </div>
                            <div class="orderdetail-item-receipt-sum-group-description">
                                <p>{{ $order->delivery_price }} {{$order->currency}}</p>
                            </div>
                        </div>
                        <div class="orderdetail-item-receipt-sum-specialgroup">
                            <div class="orderdetail-item-receipt-sum-specialgroup-title">
                                <p>{{$content_language['Haia2qvAFbJfBlG']}}</p>
                            </div>
                            <div class="orderdetail-item-receipt-sum-specialgroup-description">
                                <p>{{ $subTotal + $order->delivery_price }} {{$order->currency}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/profile/orderdetailwash&dry.js"></script>
@endsection
