@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/tankchange.css" />
@endsection


@section('sections')
    <div class="container">
        <div class="header flex items-center gap-4">
            <div class="title flex items-center gap-2">
                <img src="/images/gas/product-list-icon.png" alt="" width="100">
                <h1>รายการทั้งหมด:</h1>
            </div>
        </div>
        <div class="content flex w-full h-full justify-center overflow-y-auto">
            <div class="content-products w-full h-full">
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
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        const card_items = document.querySelectorAll(".card-item")
        card_items.forEach((item) => {
            item.addEventListener('click', () => {
                item.classList.toggle('active')
                setTimeout(() => {
                    item.classList.toggle('active')

                }, 200);
            })
        })
    </script>

@endsection
