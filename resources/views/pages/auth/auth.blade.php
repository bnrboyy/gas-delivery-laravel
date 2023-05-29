@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/auth.css" />
@endsection

@section('sections')
    <div class="container">
        <div class="service-box">
            <div class="btn-left btn-service">
                <img src="/images/gas/gas-cylinder.png" alt="" width="80">
                <h1>เปลี่ยนถังแก๊ส</h1>
            </div>
            <div class="btn-right btn-service">
                <img src="/images/gas/gas-cylinder2.png" alt="" width="80">
                <h1>สั่งถังแก๊สหรืออุปกรณ์</h1>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let btn_left = document.querySelector(".btn-left")
        let btn_right = document.querySelector(".btn-right")

        btn_left.addEventListener("click", () => {
            btn_left.classList.toggle("active")
            setTimeout(() => {
                btn_left.classList.toggle("active")
                window.location.href = "/tankchange"

            }, 200)
        })
        btn_right.addEventListener("click", () => {
            btn_right.classList.toggle("active")
            setTimeout(() => {
                btn_right.classList.toggle("active")
                window.location.href = "/ordering"

            }, 200)
        })
        // const langBtn = document.querySelector('.lang-button')
        // const langMenuBtn = document.querySelector('.menu-language-button')
        // langBtn.addEventListener('click', function() {
        //     const langDropdown = document.querySelector('.lang-dropdown')
        //     langDropdown.classList.toggle('show')
        // })
        // langBtn.addEventListener('blur', function() {
        //     const langDropdown = document.querySelector('.lang-dropdown')
        //     setTimeout(() => {
        //         langDropdown.classList.remove('show')
        //     }, 300);
        // })
        // langMenuBtn.addEventListener('click', function() {
        //     const langMenu = document.querySelector('.menu-language')
        //     langMenu.classList.toggle('show')
        // })

        // function changeLanguage(lang) {
        //     location.href = `/changeLanguage?lang=${lang}`
        // }
    </script>
@endsection
