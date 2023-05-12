@extends('layouts.main-layout')

@section('sections')
    <section id="map">
        <div class="map">
            <div class="map-item">
                <div id="map-google" style="height: 90vh;"></div>
                <div class="map-item-button">
                    <figure>
                        <img src="/img/map/searchicon.png" alt="searchIcon">
                    </figure>
                    <input type="text" id="input_search" placeholder="Search">
                </div>
                <div class="map-item-group"
                    style="position: fixed; width:100%; display:flex; justify-content:space-between; align-items:center; max-width:90vw; top:5rem;left:50%;transform:translate(-50%, -50%);">
                    <div class="map-item-close"
                        style="cursor: pointer;display:none;justify-content:center;align-items:center; top:6rem; left:2.25rem; background:#fff; width:35px; height:35px; border-radius:50px;box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.25);">
                        <div class="map-item-close-line-1"
                            style="background:#000; width:15px; height:2px;position: absolute;
                        transform: rotate(45deg);">
                        </div>
                        <div class="map-item-close-line-2 maximum"
                            style="background:#000; width:15px; height:2px;position: absolute;
                        transform: rotate(-45deg);" data-maximum="{{$maximum_radius}}">
                        </div>
                    </div>
                    <figure class="map-item-location"
                        style="cursor: pointer;gap:.25rem;box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.25);border-radius:18px;display:none;justify-content:center;align-items:center;background:#fff;top:6rem; right:2.25rem;width: 100%; max-width:106px; height:35px;">
                        <img src="/img/map/location.png" alt="">
                        <p>Location</p>
                    </figure>
                </div>
                <div class="map-item-detail"
                    style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.25);
                    border-radius: 11px;transform:translate(-50%, -50%); max-width: 90vw; background:#fff;flex-direction:column; position: fixed;top: 11.5rem;left: 50%;width: 100%;height: 100%; max-height: 150px;display: none;justify-content: space-between;align-items: center;z-index: 0;padding:1.5rem 1.5rem;">
                    <div class="map-item-detail-address">
                        <p style="font-weight:300;font-size:12px;"></p>
                    </div>
                    <div class="map-item-detail-confirm" style="width: 100%">
                        <button type="button" id="btn_confirm" onclick="handlerConfirm()"
                            style="display:flex; justify-content:center; align-items:center; margin: 0 auto; background: #0170fa;width: 100%;max-width: 241px;height: 36px;max-height: 36px;color: #fff;border-radius: 18px;">Choose
                            this location</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYXs0euMCEZ7Um37NqJfu8r9RkT5qlYk8&libraries=geometry,marker,places&callback=initMap&v=weekly"
        defer></script>
    <script src="/js/pages/map.js"></script>
@endsection
