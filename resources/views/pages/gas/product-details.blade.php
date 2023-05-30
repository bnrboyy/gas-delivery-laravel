@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/product-details.css">
@endsection

@section('sections')
    <div class="container">
        <div class="product-details flex items-center justify-center p-4">
            <div class="details flex w-full items-center p-4 gap-4">
                <div class="card-item">
                    <div class="content-head">
                        <img src="/images/gas/gas-cylinder.png" alt="">
                    </div>

                    <div class="box-details-action w-full">
                        <button class="btn-decrement w-6 h-6">
                            <figure>
                                <img src="/images/icons/minus.png" alt="">
                            </figure>
                        </button>
                        <div class="show-quantity">
                            <p>จำนวน</p>
                            <div class="show-quantity-number">
                                <p>1</p>
                            </div>
                        </div>
                        <button class="btn-increment w-6 h-6">
                            <figure>
                                <img src="/images/icons/plus.png" alt="">
                            </figure>
                        </button>
                    </div>
                </div>
                <div class="details-item flex flex-col gap-4">
                    <div class="box-details w-full">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, mollitia!</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, mollitia!</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, mollitia!</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, mollitia!</p>
                    </div>
                    <div class="box-details-action w-full">
                        <p>ราคารวม: <span style="color: #0170fa;">269 บาท</span> </p>

                        <button class="btn-addToCart">เพิ่มสินค้า</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const btn_increment = document.querySelector(".btn-increment")
        const btn_decrement = document.querySelector(".btn-decrement")
        const show_number = document.querySelector(".show-quantity-number p");

        btn_decrement.addEventListener('click', () => {
            if (parseInt(show_number.innerText) === 1) return false;
            show_number.innerHTML = `${parseInt(show_number.innerText) - 1}`;
        })
        btn_increment.addEventListener('click', () => {
            if (parseInt(show_number.innerText) === 5) return false;
            show_number.innerHTML = `${parseInt(show_number.innerText) + 1}`;
        })

    </script>

@endsection

