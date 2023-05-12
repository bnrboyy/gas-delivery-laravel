@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/auth/register.css">
@endsection

@section('sections')
    <section id="register">

        <div class="register">
            <div class="register-item">
                <div class="register-item-header">
                    <div class="register-item-header-title">
                        <p>Sign Up</p>
                    </div>
                </div>
                <div class="register-item-form">
                    <div class="register-item-form-input">
                        <div class="register-item-form-input-name">
                            <label for="name">{{$content_language['u1VNlE6GGA9GRwU']}}</label>
                            <input id="name" type="text" placeholder="Enter your name" onkeyup="inputEmpty(this)"/>
                        </div>
                        <div class="register-item-form-input-email">
                            <label for="email">{{$content_language['6ZmmoqU8PnKBjdR']}}</label>
                            <input id="email" type="email" placeholder="Enter your email" onkeyup="emailValid(this)"/>
                        </div>
                        <div class="register-item-form-input-line">
                            <label for="line">{{$content_language['fg0zoRDFPOu9G5J']}}</label>
                            <input id="line" type="text" placeholder="Enter your line ID" />
                        </div>
                        <div class="register-item-form-input-phone">
                            <label for="phone">{{$content_language['r1xGQX3ouMMsikn']}}</label>
                            <input id="phone" type="number" placeholder="Enter your phone number" onkeydown="return event.keyCode !== 69" onkeyup="inputEmpty(this)"/>
                        </div>
                        <div class="register-item-form-input-password">
                            <label for="password">
                                {{$content_language['ovlgbe5QQYjnRdV']}}
                                <img onclick="showPassword()" src="/img/register/showpassword.png" alt="showPasswordIcon" />
                            </label>
                            <input id="password" type="password" placeholder="***************" onkeyup="inputEmpty(this)" />
                        </div>
                        <div class="register-item-form-input-confirm">
                            <label for="confirm">
                                {{$content_language['OM8Jr7JsPn1kkiY']}}
                                <img onclick="showConfirm()" src="/img/register/showpassword.png" alt="showPasswordIcon" />
                            </label>
                            <input id="confirm" type="password" placeholder="***************" onkeyup="inputEmpty(this)" />
                        </div>
                    </div>
                    <div class="register-item-form-action">
                        <button onclick="onSignUp()">{{$content_language['599p8c8jsIxU0ql']}}</button>
                        <div class="register-item-form-action-policy">
                            <input id="policy" type="checkbox" />
                            <label for="policy">
                                <p>{{$content_language['1adeTO2gojB2ilw']}}</p>
                            </label>
                        </div>
                    </div>
                    <div class="register-item-form-line"></div>
                    <div class="register-item-form-register">
                        <p>{{$content_language['1iYRQlv6cdipsOK']}}</p>
                        <button> <a href="/auth/auth-login">{{$content_language['uuIcJxsfRL2KrA4']}}</a></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/auth/register.js"></script>
@endsection
