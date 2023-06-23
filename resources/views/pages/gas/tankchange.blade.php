@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/tankchange.css" />
@endsection


@section('sections')
    <div class="container">
        <div class="header w-full flex items-center gap-4">
            <div class="title flex items-center gap-2">
                <img src="/images/gas/product-list-icon.png" alt="" width="100">
                <p>รายการทั้งหมด : เปลี่ยนถังแก๊ส</p>
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
    </script>
@endsection
