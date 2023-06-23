@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/tankchange.css" />
@endsection


@section('sections')
    <div class="container">
        <div class="header flex items-center justify-between">
            <div class="title flex items-center gap-2">
                <img src="/images/gas/product-list-icon.png" alt="" width="100">
                <p>สั่งสินค้า : {{$cate_title}}</p>
            </div>
            <div class="relative w-auto h-auto">
                <button class="btn-cate flex items-center justify-center gap-2 w-[130px] h-[35px] rounded border-2 border-gray-900">ประเภทสินค้า <img class="img-arrow max-w-[20px] duration-300"
                        src="images/icons/down-arrow.png" alt=""></button>

                <div class="dropdown hidden absolute w-[130px] h-[120px] text-white bg-gray-900 rounded z-10 top-[2.5rem] duration-300" >
                    <ul class="w-full">
                        <a class="w-full bg-inherit hover:bg-gray-700" href="/ordering"><li class="p-2">สินค้าทั้งหมด</li></a>
                        <a class="w-full bg-inherit hover:bg-gray-700" href="/ordering?cateid=2"><li class="p-2">ถังแก๊สใหม่</li></a>
                        <a class="w-full bg-inherit hover:bg-gray-700" href="/ordering?cateid=3"><li class="p-2">อุปกรณ์</li></a>

                    </ul>
                </div>
            </div>
        </div>
        <div class="content flex w-full h-full justify-center overflow-y-auto">
            <div class="content-products w-full h-full">
                @foreach ($products as $product)
                    <div class="card-item" productId="{{ $product->id }}">
                        <div class="content-head">
                            <img class="w-full h-full" src="{{ $product->thumbnail_link }}" alt="">
                        </div>
                        <div class="product-details w-full flex flex-col space-y-4">
                            <p class="text-lg">{{ $product->title }}</p>
                            <span class="text-xl text-sky-500/100">ราคา : {{ $product->price }} บาท</span>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        const card_items = document.querySelectorAll(".card-item")
        const btn_cate = document.querySelector(".btn-cate")
        const dropdown = document.querySelector(".dropdown")
        const arrow = document.querySelector(".img-arrow")

        card_items.forEach((item) => {
            item.addEventListener('click', () => {
                let id = item.getAttribute('productId')
                item.classList.toggle('active')
                setTimeout(() => {
                    item.classList.toggle('active')
                    window.location.href = `/product-details/${id}`
                }, 200);
            })
        })

        btn_cate.addEventListener('click', () => {
            dropdown.classList.toggle('hidden')
            arrow.classList.toggle('active')
        })

    </script>
@endsection
