@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/auth.css" />
@endsection

@section('sections')
    <div class="container">
        <div class="w-full h-full flex flex-col">
            <div class="tiitle flex items-center w-full h-[90px] p-4 text-[2rem]">
                <p class="">เกี่ยวกับเรา</p>
            </div>
            <div class="content w-full h-full flex items-center justify-center p-4">
                <div class="content-left w-1/2 h-full p-4 bg-white border border-right-black">
                    <p class="leading-10">JUPP GAS-DELIVERY ( จุ๊ปแก๊สโนนทัน ขอนแก่น ).</p>
                    <p class="">ผู้ให้บริการส่งแก๊ส ส่งตรงถึงหน้าบ้าน Lorem ipsum dolor sit, amet consectetur
                        adipisicing elit. Perspiciatis, error.</p>
                    <br />
                    <P class="">ที่อยู่ : 102/44 xx xxxxxx xxxxx</P>
                    <P class="">เบอร์โทร : 09099999999 </P>
                    <br />
                    <div class="flex w-full h-[50px] items-center gap-6">
                        <div class="flex items-center gap-2">
                            <figure class="max-w-[50px]">
                                <img src="images/icons/facebook.png" alt="" width="100%">
                            </figure>
                            <p>Facebook : xxxxxxxxxx</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <figure class="max-w-[50px]">
                                <img src="images/icons/line2.png" alt="" width="100%">
                            </figure>
                            <p>Line : @juppgas</p>
                        </div>
                    </div>
                </div>
                <div class="content-right w-1/2 h-full p-4 bg-white">
                    <iframe width="100%" height="400" frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed/v1/place?q=16.41800902871302,102.84976831752535&key=AIzaSyDYXs0euMCEZ7Um37NqJfu8r9RkT5qlYk8"
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
