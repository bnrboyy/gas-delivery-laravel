@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/auth.css" />
    <style>
        main .container {
           height: auto !important;
       }

       .content-left {
        border-right: 1px solid rgb(199, 199, 199);
       }
        @media screen and (max-width: 1049px) {

            main {
                padding: 2rem 7px !important;
            }
           .content {
                flex-direction: column;
                padding: .5rem !important;
           }
           .content .content-left {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid rgb(199, 199, 199);
            padding: .5rem;
           }
           .content .content-right {
            width: 100%;
            padding: .5rem;
           }
        }
    </style>
@endsection

@section('sections')
    <div class="container">
        <div class="w-full h-full flex flex-col">
            <div class="tiitle flex items-center w-full h-[90px] p-4 text-[2rem]">
                <p class="">เกี่ยวกับเรา</p>
            </div>
            <div class="content w-full h-full flex justify-center bg-white p-4">
                <div class="content-left w-1/2 h-full p-4">
                    <figure class="w-full">
                        <img class="w-full max-h-[400px]" src="images/gas/gasImages.jpg" alt="" width="100">
                    </figure>
                    <p class="leading-10">JUPP GAS-DELIVERY ( จุ๊ปแก๊สโนนทัน ขอนแก่น ).</p>
                    <p class="">ผู้ให้บริการส่งแก๊ส ส่งตรงถึงหน้าบ้าน Lorem ipsum dolor sit, amet consectetur
                        adipisicing elit. Perspiciatis, error.</p>
                    <br />
                    <P class="">ที่อยู่ : 102/44 xx xxxxxx xxxxx</P>
                    <P class="">เบอร์โทร : 09099999999 </P>
                    <br />
                    <div class="flex w-full h-[50px] items-center gap-6">
                        <div class="flex items-center gap-2">
                            <a href="#">
                                <figure class="w-[40px]">
                                    <img src="images/icons/facebook.png" alt="" width="100%">
                                </figure>
                            </a>
                            <p>Facebook : xxxxxxxxxx</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="#">
                                <figure class="w-[40px]">
                                    <img src="images/icons/line2.png" alt="" width="100%">
                                </figure>
                            </a>
                            <p>Line : @juppgas</p>
                        </div>
                    </div>
                </div>
                <div class="content-right w-1/2 h-full p-4">
                    <iframe width="100%" height="400" frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed/v1/place?q={{$branch_location}}&key=AIzaSyDYXs0euMCEZ7Um37NqJfu8r9RkT5qlYk8"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection
