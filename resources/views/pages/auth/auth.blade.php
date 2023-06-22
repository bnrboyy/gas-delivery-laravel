@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/auth.css" />
@endsection

@section('sections')
    <div class="container">
        <div class="service-box">
            <div class="btn-left btn-service md:min-h-[200px]">
                <figure class="flex justify-center items-center max-w-[80px]">
                    <img class="grow w-[60px] md:w-[75px]" src="/images/gas/gas-cylinder.png" alt="">

                </figure>
                <div class="flex w-full items-center justify-center text-[16px] md:text-[20px] text-center">
                    <p>เปลี่ยนถังแก๊ส</p>

                </div>
            </div>
            <div class="btn-right btn-service p-2  md:min-h-[200px]">
                <figure class="flex justify-center items-center max-w-[80px]">
                    <img class="grow w-[60px] md:w-[75px]" src="/images/gas/gas-cylinder2.png" alt="">

                </figure>
                <div class="flex w-full items-center justify-center text-[16px] md:text-[20px] text-center">
                    <p>สั่งถังแก๊สหรืออุปกรณ์</p>

                </div>

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
