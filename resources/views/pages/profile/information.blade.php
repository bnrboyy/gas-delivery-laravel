@extends('layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="/css/profiles/information.css">
@endsection

@section('sections')
    <section id="information">
        <div class="info">
            <div class="info-item">
                <div class="info-item-profile">
                    <div class="info-item-profile-frame">
                        <figure class="info-item-profile-frame-image">
                            <img src="/{{ isset($member->profile_image) ? $member->profile_image : '' }}" alt=""
                                style="height:100%;" />
                        </figure>
                    </div>
                    <figure class="info-item-profile-icon" style="pointer-events: none">
                        <img src="/img/information/camera.png" alt="camera" />
                    </figure>
                    <div class="info-item-profile-top">
                        <div class="info-item-profile-top-date">
                            <p>{!! date('d/m/Y', strtotime($member->created_at)) !!}</p>
                        </div>
                        <div class="info-item-profile-top-id">
                            <p>ID : {{ $member->line_id }}</p>
                        </div>
                    </div>
                    <div class="info-item-profile-bottom">
                        <div class="info-item-profile-bottom-notice">
                            <p>Welcome Back</p>
                        </div>
                        <div class="info-item-profile-bottom-name">
                            <p>{{ $member->member_name }}</p>
                        </div>
                    </div>
                </div>
                <div class="info-item-information">
                    <div class="info-item-information-title">
                        <p>{{$content_language['bgWLRdITRIrMRDC']}}</p>
                    </div>
                    <div class="info-item-information-group">
                        <div class="info-item-information-group-title">
                            <p>{{$content_language['QlHspnlfBPJ3nge']}}</p>
                        </div>
                        <div class="info-item-information-group-content input-group info-item-input-group">
                            <input id="name" type="text" value="{{ $member->member_name }}" disabled
                                onblur="onBlurFunction(this)" onkeyup="inputEmpty(this)" />
                            <figure class="info-item-information-group-content-icon" onclick="showInput(this)">
                                <img src="/img/information/edit.png" alt="editIcon" />
                            </figure>
                        </div>
                        <div class="info-item-information-group-line"></div>
                    </div>
                    <div class="info-item-information-group">
                        <div class="info-item-information-group-title">
                            <p>{{$content_language['oJA9NRRUOyiSLJx']}}</p>
                        </div>
                        <div class="info-item-information-group-content input-group info-item-input-group">
                            <input id="phone" type="number" value="{{ $member->phone_number }}" disabled
                                onblur="onBlurFunction(this)" onkeydown="return event.keyCode !== 69" onkeyup="inputEmpty(this)" />
                            <figure class="info-item-information-group-content-icon" onclick="showInput(this)">
                                <img src="/img/information/edit.png" alt="editIcon" />
                            </figure>
                        </div>
                        <div class="info-item-information-group-line"></div>
                    </div>
                    <div class="info-item-information-group">
                        <div class="info-item-information-group-title">
                            <p>{{$content_language['m75qxWr3Yb99L8F']}}</p>
                        </div>
                        <div class="info-item-information-group-content input-group info-item-input-group">
                            <input id="email" type="text" value="{{ $member->email }}" disabled
                                onblur="onBlurFunction(this)" onkeyup="validateEmail(this)" />
                            <figure class="info-item-information-group-content-icon" onclick="showInput(this)">
                                <img src="/img/information/edit.png" alt="editIcon" />
                            </figure>
                        </div>
                        <div class="info-item-information-group-line"></div>
                    </div>
                    <div class="info-item-information-group">
                        <div class="info-item-information-group-title">
                            <p>{{$content_language['7ADqZahT2HBmlwB']}}</p>
                        </div>
                        <div class="info-item-information-group-content input-group info-item-input-group">
                            <input id="line" type="text" value="{{ $member->line_id }}" disabled
                                onblur="onBlurFunction(this)" />
                            <figure class="info-item-information-group-content-icon" onclick="showInput(this)">
                                <img src="/img/information/edit.png" alt="editIcon" />
                            </figure>
                        </div>
                        <div class="info-item-information-group-line"></div>
                    </div>
                    <div class="info-item-information-group">
                        <div class="info-item-information-group-title">
                            <p>{{$content_language['KPu4GXZqSGgPLfK']}}</p>
                        </div>
                        <div class="info-item-information-group-content input-group info-item-input-group">
                            <p id="address">
                                {{ !is_null($member->address) && $member->address !== '' ? $member->address : 'Choose an address' }}
                            </p>
                            <figure class="info-item-information-group-content-icon">
                                <a href="/map?page=profile/information&type=pickup"><img src="/img/information/address.png"
                                        alt="addressIcon" /></a>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="info-item-btnpassword">
                    <button onclick="showChangePassword()" type="button">
                        {{$content_language['n9EtCIMfe2YkK87']}}
                    </button>
                </div>
                <div class="info-item-password">
                    <div class="info-item-password-title">
                        <p>{{$content_language['n9EtCIMfe2YkK87']}}</p>
                    </div>
                    <div class="info-item-password-group">
                        <label for="current">{{$content_language['Ay9U7lreuOhEcxn']}}</label>
                        <input id="current" type="password" placeholder="**********"/>
                    </div>
                    <div class="info-item-password-group">
                        <label for="newPassword">{{$content_language['Mr3SswCXQenfeFc']}}</label>
                        <input id="newPassword" type="password" placeholder="**********"/>
                    </div>
                    <div class="info-item-password-group">
                        <label for="confirmNewPassword">{{$content_language['cNIUl7XH9EwFMh8']}}</label>
                        <input id="confirmNewPassword" type="password" placeholder="**********"/>
                    </div>
                    <div class="info-item-password-button">
                        <button onclick="discard()" class="info-item-password-button-yeet">
                            {{$content_language['1aI6GTGuyzZBu3G']}}
                        </button>
                        <button onclick="newPassword({{ $member->id }})" class="info-item-password-button-yoink">
                            {{$content_language['sRMDcYUyI7XtLHK']}}
                        </button>
                    </div>
                </div>
                <div class="info-item-botton">
                    <button onclick="nextPage({{ $member->id }})">{{$content_language['KZci2Y5o20MfBKC']}}</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/profile/information.js"></script>
@endsection
