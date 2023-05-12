@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/auth/forgot.css">
@endsection

@section('sections')
    <section id="forgotPassword">
        <div class="fgpw">
            <div class="fgpw-item">
                <div class="fgpw-item-header">
                    <div class="fgpw-item-header-title">
                        <p>Reset Password</p>
                    </div>
                </div>
                <div class="fgpw-item-form">
                    <div class="fgpw-item-form-input">
                        <div class="fgpw-item-form-input-name">
                            <label for="password">New Password</label>
                            <input id="new-password" type="password" placeholder="Enter your password" onkeyup="inputEmpty(this)"/>
                        </div>
                        <div class="fgpw-item-form-input-name">
                            <label for="password">Confirm Password</label>
                            <input id="c-password" type="password" placeholder="Confirm password" onkeyup="inputEmpty(this)"/>
                        </div>
                    </div>
                    <div class="fgpw-item-form-action">
                        <button onclick="validatePassword()">
                            RESET PASSWORD
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/auth/forgot.js"></script>
@endsection
