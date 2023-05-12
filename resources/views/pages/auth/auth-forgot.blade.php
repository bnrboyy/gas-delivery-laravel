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
                        <p>Forgot Password?</p>
                    </div>
                </div>
                <div class="fgpw-item-form">
                    <div class="fgpw-item-form-notice">
                        <p>
                            No problem! Just fill in the email below and
                            we'll send you password reset instructions!
                        </p>
                    </div>
                    <div class="fgpw-item-form-input">
                        <div class="fgpw-item-form-input-name">
                            <label for="email">E-mail</label>
                            <input id="email" type="email" placeholder="Enter your email" onkeyup="inputEmpty(this)" />
                        </div>
                    </div>
                    <div class="fgpw-item-form-action">
                        <button onclick="resetPassword()">
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
