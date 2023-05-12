@extends('layouts.main-layout')

@section('sections')
    <section id="profile">
        <div class="profile">
            <div class="profile-item">
                <div class="profile-item-header">
                    <div class="profile-item-header-box">
                        <figure class="profile-item-header-box-image" style="overflow:hidden;">
                            <img src="{{ isset($member->profile_image) ? $member->profile_image : '/img/profile/usericon.png' }}"
                                alt="userIcon" style="{{ isset($member->profile_image) ? 'height:100%;' : '' }}" />
                        </figure>
                        <div class="profile-item-header-box-top">
                            <p>{!! date('d/m/Y', strtotime($member->created_at)) !!}</p>
                            <p>ID : {{ $member->line_id }}</p>
                        </div>
                        <div class="profile-item-header-box-bot">
                            <p>Welcome Back</p>
                            <b>{{ $member->member_name }}</b>
                        </div>
                    </div>
                </div>
                <div class="profile-item-content">
                    <div class="profile-item-content-box">
                        <div class="profile-item-content-box-title">
                            <p>{{$content_language['VA387Rm5cV2ee3m']}}</p>
                        </div>
                        <div class="profile-item-content-box-list">
                            <figure onclick="infoPage()">
                                <img src="/img/profile/infoicon.png" alt="informationIcon" />
                                <p>{{$content_language['0Mi8LiRItTdSWOY']}}</p>
                            </figure>
                            <figure onclick="orderhistoryPage()">
                                <img src="/img/profile/ordericon.png" alt="orderListIcon" />
                                <p>{{$content_language['U4KviO5js49LqVr']}}</p>
                            </figure>
                            <figure onclick="homePage()">
                                <img src="/img/profile/ordermoreicon.png" alt="orderListIcon" />
                                <p>{{$content_language['8G3Qtqce5rVIn8r']}}</p>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="profile-item-button">
                    <button onclick="signOut()">{{$content_language['PVVUFd0uFvJBwtg']}}</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/profile/profile.js"></script>
@endsection
