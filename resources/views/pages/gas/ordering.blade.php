@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/tankchange.css" />
@endsection


@section('sections')
    <div class="container">
        <div class="header flex items-center justify-between">
            <div class="title flex items-center gap-2">
                <img src="/images/gas/product-list-icon.png" alt="" width="100">
                <h1>รายการทั้งหมด : สั่งสินค้า</h1>
            </div>
            <div class="flex h-full items-center w-[350px] gap-4">
                <div class="h-full w-1/3 rounded" style="box-shadow: -5px -5px 20px #dcd3d3, 5px 5px 10px #a09e9e;"></div>
                <div class="h-full w-1/3 rounded" style="box-shadow: -5px -5px 20px #dcd3d3, 5px 5px 10px #a09e9e;"></div>
                <div class="h-full w-1/3 rounded" style="box-shadow: -5px -5px 20px #dcd3d3, 5px 5px 10px #a09e9e;"></div>
            </div>
        </div>
        <div class="content flex w-full h-full justify-center overflow-y-auto">
            <div class="content-products w-full h-full">
                @foreach ($products as $product)
                    <div class="card-item" productId="{{ $product->id }}">
                        <div class="content-head">
                            <img src="{{ $product->thumbnail_link }}" alt="">
                        </div>
                        <div class="product-details w-full flex flex-col space-y-4">
                            <p class="text-lg">{{ $product->title }}</p>
                            <span class="text-xl text-sky-500/100">ราคา : {{ $product->price }} บาท</span>

                        </div>
                    </div>
                @endforeach

                {{-- <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>
                    <div class="product-details w-full flex flex-col space-y-4">
                        <p class="text-lg">ถัง 18 kg. สีแดง</p>
                        <span class="text-xl text-sky-500/100">ราคา : 150 บาท</span>
                    </div>
                </div>
                <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>
                    <div class="product-details w-full flex flex-col space-y-4">
                        <p class="text-lg">ถัง 18 kg. สีแดง</p>
                        <span class="text-xl text-sky-500/100">ราคา : 150 บาท</span>
                    </div>
                </div>
                <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>
                    <div class="product-details w-full flex flex-col space-y-4">
                        <p class="text-lg">ถัง 18 kg. สีแดง</p>
                        <span class="text-xl text-sky-500/100">ราคา : 150 บาท</span>
                    </div>
                </div>
                <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>
                    <div class="product-details w-full flex flex-col space-y-4">
                        <p class="text-lg">ถัง 18 kg. สีแดง</p>
                        <span class="text-xl text-sky-500/100">ราคา : 150 บาท</span>
                    </div>
                </div>
                <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>
                    <div class="product-details w-full flex flex-col space-y-4">
                        <p class="text-lg">ถัง 18 kg. สีแดง</p>
                        <span class="text-xl text-sky-500/100">ราคา : 150 บาท</span>
                    </div>
                </div>
                <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>
                    <div class="product-details w-full flex flex-col space-y-4">
                        <p class="text-lg">ถัง 18 kg. สีแดง</p>
                        <span class="text-xl text-sky-500/100">ราคา : 150 บาท</span>
                    </div>
                </div>
                <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>
                    <div class="product-details w-full flex flex-col space-y-4">
                        <p class="text-lg">ถัง 18 kg. สีแดง</p>
                        <span class="text-xl text-sky-500/100">ราคา : 150 บาท</span>
                    </div>
                </div>
                <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>
                    <div class="product-details w-full flex flex-col space-y-4">
                        <p class="text-lg">ถัง 18 kg. สีแดง</p>
                        <span class="text-xl text-sky-500/100">ราคา : 150 บาท</span>
                    </div>
                </div>
                <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>
                    <div class="product-details w-full flex flex-col space-y-4">
                        <p class="text-lg">ถัง 18 kg. สีแดง</p>
                        <span class="text-xl text-sky-500/100">ราคา : 150 บาท</span>
                    </div>
                </div>
                <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>
                    <div class="product-details w-full flex flex-col space-y-4">
                        <p class="text-lg">ถัง 18 kg. สีแดง</p>
                        <span class="text-xl text-sky-500/100">ราคา : 150 บาท</span>
                    </div>
                </div>
                <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>
                    <div class="product-details w-full flex flex-col space-y-4">
                        <p class="text-lg">ถัง 18 kg. สีแดง</p>
                        <span class="text-xl text-sky-500/100">ราคา : 150 บาท</span>
                    </div>
                </div> --}}
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
