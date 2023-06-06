@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/cart.css">
@endsection

@section('sections')
    <div class="container">
        <div class="header w-full">
            <div class="title w-full">
                <figure>
                    <img src="/images/icons/basket.png" alt="" width="100%">
                </figure>
                <p>ตะกร้าสินค้า</p>
            </div>
            <div class="order-numb">
                <p id="order-numb-title">เลขคำสั่งซื้อ</p>
                <p id="number">{{ $order_temp->orders_number }}</p>
            </div>

        </div>

        <div class="cart-content w-full">
            <div class="cart-item w-full">
                <div class="flex flex-col gap-2">
                    @foreach ($order_items as $item)
                        <div class="item-details w-full flex p-2 gap-2">
                            <figure class="h-full flex justify-center items-center">
                                <img src="/images/gas/gas-cylinder.png" alt="">
                            </figure>
                            <div class="details h-full flex">
                                <div class="box-details flex flex-col justify-between w-[85%]">
                                    <p class="text-gray-500">เปลี่ยนถัง</p>
                                    <div class="flex justify-between">
                                        <p>{{ $item->title }}</p>
                                        <p style="font-size: 18px; color: #0170fa;">{{ $item->price }} บาท</p>
                                    </div>
                                    <div class="details-action flex justify-start w-full">
                                        <button class="btn-decrement w-6 h-6" onclick="decrementNumb()">
                                            <figure>
                                                <img style="max-width: 18px" src="/images/icons/minus.png" alt="">
                                            </figure>
                                        </button>
                                        <div class="show-quantity">
                                            <div class="show-quantity-number">
                                                <p class="text-[22px]">{{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                        <button class="btn-increment w-6 h-6" onclick="incrementNumb()">
                                            <figure>
                                                <img style="max-width: 18px;" src="/images/icons/plus.png" alt="">
                                            </figure>
                                        </button>
                                    </div>
                                </div>

                                <div class="box-details-action flex flex-col items-center w-[15%]">
                                    <button>
                                        <img src="/images/icons/delete2.png" alt="" style="max-width: 30px">
                                    </button>
                                </div>

                            </div>

                        </div>
                    @endforeach



                    {{-- <div class="item-details w-full flex p-2 gap-2">
                        <figure class="h-full flex justify-center items-center">
                            <img src="/images/gas/gas-cylinder.png" alt="">
                        </figure>

                        <div class="details h-full flex">
                            <div class="box-details flex flex-col justify-between w-[85%]">
                                <p class="text-gray-500">เปลี่ยนถัง</p>
                                <div class="flex justify-between">
                                    <p>Lorem ipsum dolor.</p>
                                    <p style="font-size: 18px; color: #0170fa;">150 บาท</p>
                                </div>
                                <div class="details-action w-full">
                                    <button class="btn-decrement w-6 h-6" onclick="decrementNumb()">
                                        <figure>
                                            <img style="max-width: 18px" src="/images/icons/minus.png" alt="">
                                        </figure>
                                    </button>
                                    <div class="show-quantity">
                                        <div class="show-quantity-number">
                                            <p class="text-[22px]">1</p>
                                        </div>
                                    </div>
                                    <button class="btn-increment w-6 h-6" onclick="incrementNumb()">
                                        <figure>
                                            <img style="max-width: 18px;" src="/images/icons/plus.png" alt="">
                                        </figure>
                                    </button>
                                </div>
                            </div>

                            <div class="box-details-action flex flex-col items-center w-[15%]">
                                <button>
                                    <img src="/images/icons/delete2.png" alt="" style="max-width: 30px">
                                </button>
                            </div>

                        </div>

                    </div> --}}
                </div>
            </div>
        </div>

        <div class="cart-action w-full flex flex-col items-center">
            <div class="total-price w-full h-1/2 flex justify-between text-[20px]">
                <p>ราคารวม (ยังไม่รวมค่าจัดส่ง)</p>
                <p>{{ $total_price }} บาท</p>
            </div>
            <div class="w-full h-1/2 flex gap-4">
                <button class="btn-add flex justify-center items-center gap-2 text-[20px]" onclick="addItem()"> <img
                        src="/images/icons/add-item.png" alt=""> เพิ่มสินค้า</button>
                <button class="btn-confirm flex justify-center items-center gap-2 text-[20px]"
                    onclick="toConfirmOrder()"><img src="/images/icons/confirmation.png" alt="">ยืนยัน</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const quantityNumb = document.querySelector('.show-quantity-number p');

        function incrementNumb() {
            if (parseInt(quantityNumb.innerText) === 5) return false;
            quantityNumb.innerHTML = parseInt(quantityNumb.innerText) + 1;
        }

        function decrementNumb() {
            if (parseInt(quantityNumb.innerText) === 1) return false;
            quantityNumb.innerHTML = parseInt(quantityNumb.innerText) - 1;
        }

        function addItem() {
            window.location.href = "/";
        }

        function toConfirmOrder() {
            console.log('to comfirm order')
            window.location.href = "/ordersummary"
        }
    </script>
@endsection
