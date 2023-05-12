<!DOCTYPE html>
<html lang="en">

@extends('layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="/css/wash-ordering.css" />
@endsection

@section('sections')
    <section id="washNdry">
        <div class="wad">
            <div class="wad-item">

                @include('layouts.banner-profile')

                <div class="wad-item-address">
                    <div class="wad-item-address-title">
                        <p>{{$content_language['aBtjDb1h65e4rii']}}</p>
                    </div>
                    <div class="wad-item-address-distance">
                        <div class="wad-item-address-distance-group">
                            <div class="wad-item-address-distance-group-title">
                                <p>{{$content_language['5AD9NMb52XVVsp']}}</p>
                            </div>
                            <div class="wad-item-address-distance-group-description" id="input-address-pickup">
                                <p>120/34-35 Moo 24 Sila Khonkean Kho...</p>
                                <figure class="wad-item-address-distance-group-description-icon location-pickup">
                                    <a href="/map?type=pickup&page=washing"><img src="/img/wash&dry/addressicon.png"
                                            alt="addressIcon" /></a>
                                </figure>
                            </div>
                            <div class="wad-item-address-distance-group-input">
                                <input type="text" name="pickup_detail"
                                    placeholder="More Detail : Lorem ipsum dolor sit amet consectetur. Cond..." />
                            </div>
                            <div class="wad-item-address-distance-group-line"></div>
                        </div>
                        <div class="wad-item-address-distance-group">
                            <div class="wad-item-address-distance-group-title">
                                <p>{{$content_language['GGcdV5UPmpc316c']}}</p>
                            </div>
                            <div class="wad-item-address-distance-group-description" id="input-address-drop">
                                <p>120/34-35 Moo 24 Sila Khonkean Kho...</p>
                                <figure class="wad-item-address-distance-group-description-icon location-drop">
                                    <a href="/map?type=drop&page=washing"><img src="/img/wash&dry/addressicon.png"
                                            alt="addressIcon" /></a>
                                </figure>
                            </div>
                            <div class="wad-item-address-distance-group-input">
                                <input type="text" name="drop_detail"
                                    placeholder="More Detail : Lorem ipsum dolor sit amet consectetur. Cond..." />
                            </div>
                        </div>
                    </div>
                    <div class="wad-item-address-line"></div>
                </div>
                <div class="wad-item-phone">
                    <div class="wad-item-phone-title">
                        <p>{{$content_language['TuYcb5eDJauPaQu']}}</p>
                    </div>
                    <div class="wad-item-phone-input">
                        <input type="number" name="phone_number"
                            placeholder="Please enter your phone number : 089-123-4567" onkeydown="return event.keyCode !== 69" onkeyup="inputEmpty(this)" />
                    </div>
                    <div class="wad-item-phone-line"></div>
                </div>
                <div class="wad-item-detaillist">
                    <div class="wad-item-detaillist-title">
                        <p>{{$content_language['Vbegqwl9kN80ROY']}}</p>
                    </div>
                    <div class="wad-item-detaillist-input">
                        <input type="text" name="order_details"
                            placeholder="Please enter your Laundry basket : Red laundry basket" />
                    </div>
                    <div class="wad-item-detaillist-line"></div>
                </div>
                <div class="wad-item-branch">
                    <div class="wad-item-branch-title">
                        <p>{{$content_language['NbYnxbNcZntOw6o']}}</p>
                    </div>
                    <div class="wad-item-branch-list">
                        <div class="wad-item-branch-list-title">
                            <p>a branch</p>
                        </div>
                        <div class="wad-item-branch-list-description" style="position: relative">
                            <p class="branch_selected" data-id="{{$branch[0]->id}}" data-location="{{$branch[0]->location}}">{{$branch[0]->name}}</p>
                            <figure onclick="dropDown()" onblur="closeDropdown()" tabindex="0" class="wad-item-branch-list-description-dropdown active">
                                <img src="/img/wash&dry/dropdown.png" alt="dropDownIcon" />
                            </figure>
                            <div id="myDropdown" class="dropdown-content">
                                @foreach($branch as $item)
                                    <a onclick="onSelectBranch('{{$item->id}}', '{{$item->name}}', '{{$item->location}}')">{{$item->name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="wad-item-pickup">
                        <div class="wad-item-pickup-title">
                            <p>{{$content_language['B0wtvvlbp1677sp']}}</p>
                        </div>
                        <div class="wad-item-pickup-button">
                            <button onclick="timeNow()" type="button" class="active" btn-name="time_now">
                                <figure style="display: flex;">
                                    <img src="/img/wash&dry/btnunactive.png" alt="buttonActiveIcon" />
                                </figure>
                                {{$content_language['V8Ho6eF0aGr2irv']}}
                            </button>
                            <button onclick="pickUp()" type="button" btn-name="time_pickup">
                                <figure>
                                    <img src="/img/wash&dry/btnunactive.png" alt="buttonActiveIcon" />
                                </figure>
                                {{$content_language['PoiTgc3MaWyc6PA']}}
                            </button>
                            <button onclick="dropOff()" type="button" btn-name="time_drop">
                                <figure>
                                    <img src="/img/wash&dry/btnunactive.png" alt="buttonActiveIcon" />
                                </figure>
                                {{$content_language['YRqOsqSBJNXyAuF']}}
                            </button>
                        </div>
                        <div class="wad-item-pickup-calendar flex flex-col w-full justify-center items-center gap-1">
                            <label for="" class="text-base text-white font-medium">{{$content_language['tdEoWeUUPGF7TSk']}}</label>
                            <input onchange="selectTime(this)" id="time_now" style="pointer-events: none"
                                class="opacity-50 font-medium text-center w-full rounded-full" type="datetime-local">
                            <input onchange="selectTime(this)" id="time_pickup" style="display: none" class="font-medium text-center w-full rounded-full"
                                type="datetime-local">
                            <input onchange="selectTime(this)" id="time_drop" style="display: none" class="font-medium text-center w-full rounded-full"
                                type="datetime-local">
                            <p id="formatted-date"></p>
                        </div>
                    </div>
                </div>
                <div class="wad-item-type">
                    <div class="wad-item-type-clothing">
                        <div class="wad-item-type-clothing-title">
                            <p>{{$clothingTypeTitle->title}}</p>
                        </div>
                        <div class="wad-item-type-clothing-content">
                            @foreach($clothingType as $key=>$item)
                                <div class="clothing-type wad-item-type-clothing-content-group {{$key===0?"active":""}}" data-id="{{$item->id}}">
                                    <figure class="wad-item-type-clothing-content-group-pick">
                                        <img src="/img/wash&dry/pick.png" alt="pickIcon">
                                    </figure>
                                    <figure class="wad-item-type-clothing-content-group-icon">
                                        <img src="/{{$item->thumbnail_link}}" alt="{{$item->thumbnail_alt}}">
                                    </figure>
                                    <p>{{$item->title}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="wad-item-type-washing">
                        <div class="wad-item-type-washing-title">
                            <p>{{$washOrDryTitle->title}}</p>
                        </div>
                        <div class="wad-item-type-washing-content">
                            @foreach($washOrDry as $key=>$item)
                            <div class="wad-item-type-washing-content-group {{$key===0?"active":""}}" data-id="{{$item->id}}" urls="{{$item->short_url}}">
                                <figure class="wad-item-type-washing-content-group-pick">
                                    <img src="/img/wash&dry/pick.png" alt="pickIcon">
                                </figure>
                                <figure class="wad-item-type-washing-content-group-icon">
                                    <img src="/{{$item->thumbnail_link}}" alt="{{$item->thumbnail_alt}}">
                                </figure>
                                <p>{{$item->title}}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="wad-item-button">
                    <button onclick="nextPage()">{{$content_language['PIW1qcSLzU6VRoT']}}</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.2/angular.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/confirmDate/confirmDate.js"></script>
    <script src="/js/pages/washing/ordering.js"></script>
@endsection
