@extends('layouts.auth-layout')

@section('sections')
    <section id="login">
        <div class="login">
            <div class="login-item">
                <div class="login-item-header">
                    <div class="login-item-header-title">
                        <p>{{$content->cate_title}}</p>
                    </div>
                </div>
                <div class="login-item-form">
                    <div class="login-item-form-input">
                        <div class="login-item-form-input-name">
                            <label for="name">{{$content_language['mWknhrfWv6PwDmn']}}</label>
                            <input id="name" type="text" placeholder="Enter your name" value="member@example.com"/>
                        </div>
                        <div class="login-item-form-input-password">
                            <label for="password">
                                {{$content_language['oqDOCTJhyfiUGKk']}}
                                <img onclick="showPassword()" src="/img/login/showpassword.png" alt="showPasswordIcon" />
                            </label>
                            <input id="password" type="password" placeholder="***************" value="w1111111"/>
                        </div>
                    </div>
                    <div class="login-item-form-action">
                        <button onclick="login()">{{$content_language['4MvipEFalEb7VGl']}}</button>
                        <a href="/auth/auth-forgot">{{$content_language['w7GiRktRhYFXMnt']}}</a>
                    </div>
                    <div class="login-item-form-line"></div>
                    <div class="login-item-form-register">
                        <p>{{$content_language['y3WrYXiFdyNobSR']}}</p>
                        <button><a href="/auth/auth-signup">{{$content_language['dyhF0VX3CirDm7Z']}}</a></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/auth/login.js"></script>
@endsection
