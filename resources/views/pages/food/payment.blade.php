@extends('layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="/css/food-payment.css" />
@endsection

@section('sections')
    <section id="orderSummary">

        <div class="ordersum">
            <div class="ordersum-item">
                <div class="ordersum-item-header">
                    <figure class="ordersum-item-header-icon">
                        <img src="/img/order_summary/headericon.png" alt="headerIcon" />
                    </figure>
                    <div class="ordersum-item-header-title">
                        <p>Order Summary</p>
                        <figure>
                            <img src="/img/order_summary/usericon.png" alt="userIcon" />
                        </figure>
                    </div>
                </div>
                <div class="ordersum-item-ordernum">
                    <p>{{ $content_language['f5gCBGmueM8bL7O'] }}</p>
                    <b>{{ $order_details->orders_number }}</b>
                </div>
                <div class="ordersum-item-line"></div>
                <div class="ordersum-item-address">
                    <div class="ordersum-item-address-title">
                        <p id="maximum" data="{{ $maximum_radius }}">{{ $content_language['7Yhxn0M6FyeGl3Z'] }}</p>
                    </div>
                    <div class="ordersum-item-address-distance">
                        <div class="ordersum-item-address-distance-group">
                            <div class="ordersum-item-address-distance-group-title">
                                <p>Address</p>
                            </div>
                            <div class="ordersum-item-address-distance-group-description" id="input-address-drop"
                                drop-location="{{ $order_details->delivery_drop }}"
                                drop-address="{{ $order_details->delivery_drop_address }}">
                                <p>{{ $order_details->delivery_drop_address }}</p>
                                <figure class="location-drop">
                                    <a href="/map?type=drop&page=foods/payment"><img src="/img/order_summary/pin.png"
                                            alt="pinIcon" /></a>
                                </figure>
                            </div>
                            <div class="ordersum-item-address-distance-group-detail">
                                <input type="text" value="{{ $order_details->delivery_drop_address_more }}"
                                    name="drop_detail"
                                    placeholder="More Detail : Lorem ipsum dolor sit amet consectetur. Cond..." />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ordersum-item-line"></div>
                <div class="ordersum-item-phone">
                    <div class="ordersum-item-phone-title">
                        <p>{{ $content_language['7H8EKBAAbPaBOFl'] }}</p>
                    </div>
                    <div class="ordersum-item-phone-number">
                        <input type="number" name="phone_number" value="{{ $order_details->phone_number }}"
                            placeholder="Please enter your phone number : 089-123-4567"
                            onkeydown="return event.keyCode !== 69" onkeyup="inputEmpty(this)" />
                    </div>
                </div>
                <div class="ordersum-item-line"></div>
                <div class="ordersum-item-branch">
                    <div class="ordersum-item-branch-title">
                        <p>{{ $content_language['dc3lgbeM61vY942'] }}</p>
                    </div>
                    <div class="ordersum-item-branch-content">
                        <div class="ordersum-item-branch-content-title">
                            <p>a branch</p>
                        </div>
                        <div class="wad-item-branch-list-description" style="position: relative">
                            <p class="branch_selected" data-location="{{ $order_details->branch_location }}"
                                data-id="{{ $order_details->branch_id }}">
                                {{ $order_details->branch_name }}</p>
                            <figure onclick="dropDown()" onblur="closeDropdown()" tabindex="0"
                                class="wad-item-branch-list-description-dropdown active">
                                <img src="/img/wash&dry/dropdown.png" alt="dropDownIcon" />
                            </figure>
                            <div id="myDropdown" class="dropdown-content">
                                @foreach ($branch as $item)
                                    <a onclick="onSelectBranch('{{ $item->id }}')">{{ $item->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ordersum-item-line"></div>
                <div class="ordersum-item-shippingtime">
                    <div class="ordersum-item-shippingtime-title">
                        <p>{{ $content_language['5TOmOsWuMrugmS6'] }}</p>
                    </div>
                    <div class="ordersum-item-shippingtime-description">
                        <p>{{ $content_language['5TOmOsWuMrugmS6'] }}</p>
                    </div>
                    <div class="ordersum-item-shippingtime-content">
                        <div class="ordersum-item-shippingtime-content-title">
                            <p>Time</p>
                        </div>
                        <div class="ordersum-item-shippingtime-content-description">
                            <p>{!! date('l, d, F, Y', strtotime($order_details->shipping_date)) .
                                '<br />' .
                                'Time: ' .
                                date('A H:i', strtotime($order_details->shipping_date)) !!}</p>
                        </div>
                    </div>
                </div>
                <div class="ordersum-item-line"></div>
                <div class="ordersum-item-list">
                    <div class="ordersum-item-list-header">
                        <div class="ordersum-item-list-header-title">
                            <p>{{ $content_language['1rbNgqKi2Z0RbGA'] }}</p>
                        </div>
                        <div class="ordersum-item-list-header-description">
                            <p>{{ $content_language['SSLvj3L2arv0n4S'] }}</p>
                        </div>
                    </div>
                    <div class="ordersum-item-list-content">
                        @foreach ($order_items as $key => $value)
                            <div class="ordersum-item-list-content-group">
                                <div class="ordersum-item-list-content-group-maingroup">
                                    <figure class="ordersum-item-list-content-group-maingroup-left">
                                        <img src="/{{ $value->thumbnail_link }}" alt="dishImage1" />
                                    </figure>
                                    <div class="ordersum-item-list-content-group-maingroup-right">
                                        <div class="ordersum-item-list-content-group-maingroup-right-title">
                                            <p>{{ $value->cate_title }}</p>
                                            <div class="cart-item-list-content-group-right-top-right">
                                                <div style="display: flex; flex-direction: column; align-items: end;">
                                                    @if ($value->microwave_name)
                                                        <p>Mi: {{ $value->microwave_name }}</p>
                                                    @elseif($value->sweetness_name)
                                                        <p>Mi: {{ $value->sweetness_name }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cart-item-list-content-group-right-mid">
                                            <p>{{ $value->product_name }}</p>
                                        </div>
                                        <div class="cart-item-list-content-group-right-bot">
                                            <div class="cart-item-list-content-group-right-bot-left">
                                                <p>{{ $value->price }} {{ $currency_symbol }}</p>
                                            </div>
                                            <div class="cart-item-list-content-group-right-bot-right">
                                                <p class="quantity">x{{ $value->quantity }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ordersum-item-list-content-group-line"></div>
                            </div>
                        @endforeach

                        <div class="ordersum-item-list-content-sum">
                            <div class="ordersum-item-list-content-sum-title">
                                <p>{{ $content_language['PWSMvwRtaU6sSIO'] }}</p>
                                <p>{{ $content_language['qsLpFtrvkJon7yW'] }}</p>
                                <b>{{ $content_language['Haia2qvAFbJfBlG'] }}</b>
                            </div>
                            <div class="ordersum-item-list-content-sum-description" id="price_per_kilo"
                                data-price="{{ $price_per_kilo }}">
                                <p name="subtotal" data="{{ $sub_total }}">{{ $sub_total }} {{ $currency_symbol }}
                                </p>
                                <p name="shipped">0 {{ $currency_symbol }}</p>
                                <b name="total">{{ $sub_total + 0 }} {{ $currency_symbol }}</b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ordersum-item-line"></div>
                <div class="ordersum-item-payment">
                    <div class="ordersum-item-payment-header">
                        <div class="ordersum-item-payment-header-title">
                            <p>{{ $content_language['kUP6dQ7fL9vPvsr'] }}</p>
                        </div>
                        <div class="ordersum-item-payment-header-description">
                            <p>{{ $content_language['ORYUSsKvBhqEQDl'] }}</p>
                        </div>
                    </div>
                    <div class="ordersum-item-payment-type">
                        <div class="ordersum-item-payment-type-group" type="transfer">
                            <figure>
                                <img src="/img/order_summary/pick.png" alt="pickIcon" />
                            </figure>
                            <p>{{ $content_language['U9wUDU7CBossWRy'] }}</p>
                        </div>
                        <div class="ordersum-item-payment-type-group" type="cash">
                            <figure>
                                <img src="/img/order_summary/pick.png" alt="pickIcon" />
                            </figure>
                            <p>{{ $content_language['Kv2QOmFVbdg5icr'] }}</p>
                        </div>
                    </div>
                    <div class="ordersum-item-payment-bank">
                        @foreach ($banks as $bank)
                            <div class="ordersum-item-payment-bank-group">
                                <figure>
                                    <img src="/{{ $bank->bank_image }}" alt="bankIcon1" />
                                </figure>
                                <div class="ordersum-item-payment-bank-group-content">
                                    <div class="ordersum-item-payment-bank-group-content-title">
                                        <p>{{ $bank->bank_name }}</p>
                                    </div>
                                    <div class="ordersum-item-payment-bank-group-content-description">
                                        <p>{{ $bank->bank_number }} {{ $bank->bank_account }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="ordersum-item-payment-bank-line"></div>
                        @endforeach
                    </div>
                    <div class="ordersum-item-payment-slip">
                        <div class="ordersum-item-payment-slip-header">
                            <div class="ordersum-item-payment-slip-header-title">
                                <p>{{ $content_language['i83LfmDE84SJFMS'] }}</p>
                            </div>
                            <div class="ordersum-item-payment-slip-header-description">
                                <p>{{ $content_language['QUOb8F327AEoVCH'] }}</p>
                            </div>
                        </div>
                        <div class="ordersum-item-payment-slip-content">
                            <div class="ordersum-item-payment-slip-content-left">
                                <figure class="ordersum-item-payment-slip-content-left-upload">
                                    <img src="/img/order_summary/upload.png" alt="uploadIcon" />
                                </figure>
                            </div>
                            <div class="ordersum-item-payment-slip-content-right">
                                <p>{{ $content_language['PGPC1VPte0N2dM5'] }}</p>
                                <button onclick="uploadFile()"
                                    type="button">{{ $content_language['VpSaD6RRUra02EC'] }}</button>
                                <p>or</p>
                                <button type="button">{{ $content_language['cS4O1JRbehVEk3t'] }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ordersum-item-button">
                    <div class="ordersum-item-button-title">
                        <p>{{ $content_language['7z14qgoHMPZl8ks'] }}</p>
                        <b name="totalb">{{ $sub_total + 0 }} {{ $currency_symbol }}</b>
                    </div>
                    <div class="ordersum-item-button-description">
                        <p>{{ $content_language['tk5I9UXxkKmoRTq'] }}</p>
                    </div>
                    <button type="button" onclick="confirmOrder()">{{ $content_language['8Fpiey7pzpWEqBa'] }}</button>
                </div>
                <input id="currency" type="hidden" value="{{ $currency_symbol }}">
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYXs0euMCEZ7Um37NqJfu8r9RkT5qlYk8&libraries=geometry,marker,places&callback=initMap&v=weekly"
        defer></script>
    <script src="/js/pages/foods/payment.js"></script>
@endsection
