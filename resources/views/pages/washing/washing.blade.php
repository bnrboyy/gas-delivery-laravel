@extends('layouts.main-layout')

@section('sections')
    <section id="washing">
        <div class="washing">
            <div class="washing-item">

                @include('layouts.banner-profile')

                <div class="washing-item-type">
                    <div class="washing-item-type-capacity">
                        <div class="washing-item-type-capacity-title">
                            <p>{{ $capacityTitle->title }}</p>
                        </div>
                        <div class="washing-item-type-capacity-description">
                            <p>{{ $capacityTitle->details }}</p>
                        </div>
                        <div class="washing-item-type-capacity-content">
                            @foreach ($capacity as $key => $item)
                                <div class="washing-item-type-capacity-content-group {{ $key === 0 ? 'active' : '' }}"
                                    data-id="{{ $item->id }}" data-price="{{ $item->price }}">
                                    <figure class="washing-item-type-capacity-content-group-pick">
                                        <img src="/img/washing/pick.png" alt="pickIcon">
                                    </figure>
                                    <figure class="washing-item-type-capacity-content-group-icon">
                                        <img src="/{{ $item->thumbnail_link }}" alt="{{ $item->thumbnail_alt }}">
                                    </figure>
                                    <p>{{ $item->title }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="washing-item-type-watertemp">
                        <div class="washing-item-type-watertemp-title">
                            <p>{{ $waterTempTitle->title }}</p>
                        </div>
                        <div class="washing-item-type-watertemp-description">
                            <p>{{ $waterTempTitle->details }}</p>
                        </div>
                        <div class="washing-item-type-watertemp-content">
                            @foreach ($waterTemp as $key => $item)
                                <div class="washing-item-type-watertemp-content-group {{ $key === 0 ? 'active' : '' }}"
                                    data-id="{{ $item->id }}" data-price="{{ $item->price }}">
                                    <figure class="washing-item-type-watertemp-content-group-pick">
                                        <img src="/img/washing/pick.png" alt="pickIcon">
                                    </figure>
                                    <figure class="washing-item-type-watertemp-content-group-icon">
                                        <img src="/{{ $item->thumbnail_link }}" alt="{{ $item->thumbnail_alt }}">
                                    </figure>
                                    <p>{{ $item->title }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="washing-item-type-button">
                        <button onclick="saveWashing('/washing/dry')">
                            <figure>
                                <img src="/img/washing/plus.png" alt="plusIcon">
                            </figure>
                            {{$content_language['T9etzQlS2d60d2v']}}
                        </button>
                    </div>
                </div>
                <div class="washing-item-button">
                    <button onclick="summaryPage()" class="btn-summary" data-price="{{ $total_list }}">
                        <figure>
                            <img src="/img/washing/btn1icon.png" alt="washingIcon">
                            {{ $total_list }}
                        </figure>
                        <p>|</p>
                        <p>{{ $total_price }} {{$currency_symbol}}</p>
                    </button>
                    <button onclick="saveWashing('/washing/cart')" class="add-to-cart">
                        <figure>
                            <img src="/img/washing/btn2icon.png" alt="dryingIcon">
                            {{$content_language['Uq0uPjcGCK5s8ik']}}
                        </figure>
                        <p>0 {{$currency_symbol}}</p>
                    </button>
                </div>
                <input id="currency" type="hidden" name="" value="{{$currency_symbol}}">
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/washing/washing.js"></script>
@endsection
