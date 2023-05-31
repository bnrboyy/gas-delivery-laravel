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
                <p id="number">ORD-12345667890</p>
            </div>

        </div>

        <div class="cart-content w-full">
            <div class="cart-item w-full">
                <div class="flex flex-col gap-2">

                    <div class="item-details w-full flex p-2 gap-2">
                        <figure class="h-full flex justify-center items-center">
                            <img src="/images/gas/gas-cylinder.png" alt="">
                        </figure>

                        <div class="details h-full flex">
                            <div class="box-details flex flex-col justify-between w-[85%]">
                                <p class="text-gray-500">เปลี่ยนถัง</p>
                                <div class="flex justify-between">
                                    <p>Lorem ipsum dolor.</p>
                                    <p>150 บาท</p>
                                </div>
                                <div class="details-action w-full">
                                    <button class="btn-decrement w-6 h-6">
                                        <figure>
                                            <img style="max-width: 18px" src="/images/icons/minus.png" alt="">
                                        </figure>
                                    </button>
                                    <div class="show-quantity">
                                        <div class="show-quantity-number">
                                            <p class="text-[22px]">1</p>
                                        </div>
                                    </div>
                                    <button class="btn-increment w-6 h-6">
                                        <figure>
                                            <img style="max-width: 18px" src="/images/icons/plus.png" alt="">
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
                    <div class="item-details w-full flex p-2 gap-2">
                        <figure class="h-full flex justify-center items-center">
                            <img src="/images/gas/gas-cylinder.png" alt="">
                        </figure>
                        <div class="details h-full flex">
                            <div class="box-details flex flex-col justify-between w-[85%]">
                                <p class="text-gray-500">เปลี่ยนถัง</p>
                                <div class="flex justify-between">
                                    <p>Lorem ipsum dolor.</p>
                                    <p>150 บาท</p>
                                </div>
                                <div class="details-action w-full">
                                    <button class="btn-decrement w-6 h-6">
                                        <figure>
                                            <img style="max-width: 18px" src="/images/icons/minus.png" alt="">
                                        </figure>
                                    </button>
                                    <div class="show-quantity">
                                        <div class="show-quantity-number">
                                            <p class="text-[22px]">1</p>
                                        </div>
                                    </div>
                                    <button class="btn-increment w-6 h-6">
                                        <figure>
                                            <img style="max-width: 18px" src="/images/icons/plus.png" alt="">
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
                    <div class="item-details w-full flex p-2 gap-2">
                        <figure class="h-full flex justify-center items-center">
                            <img src="/images/gas/gas-cylinder.png" alt="">
                        </figure>

                        <div class="details h-full flex">
                            <div class="box-details flex flex-col justify-between w-[85%]">
                                <p class="text-gray-500">เปลี่ยนถัง</p>
                                <div class="flex justify-between">
                                    <p>Lorem ipsum dolor.</p>
                                    <p>150 บาท</p>
                                </div>
                                <div class="details-action w-full">
                                    <button class="btn-decrement w-6 h-6">
                                        <figure>
                                            <img style="max-width: 18px" src="/images/icons/minus.png" alt="">
                                        </figure>
                                    </button>
                                    <div class="show-quantity">
                                        <div class="show-quantity-number">
                                            <p class="text-[22px]">1</p>
                                        </div>
                                    </div>
                                    <button class="btn-increment w-6 h-6">
                                        <figure>
                                            <img style="max-width: 18px" src="/images/icons/plus.png" alt="">
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
                </div>
            </div>
        </div>

        <div class="cart-action w-full flex flex-col items-center">
            <div class="total-price w-full h-1/2 flex justify-between text-[20px]">
                <p>ราคารวม (ยังไม่รวมค่าจัดส่ง)</p>
                <p>888 บาท</p>
            </div>
            <div class="w-full h-1/2 flex gap-4">
                <button class="btn-add flex justify-center items-center gap-2 text-[20px]" onclick="addItem()"> <img
                        src="/images/icons/add-item.png" alt=""> เพิ่มสินค้า</button>
                <button class="btn-confirm flex justify-center items-center gap-2 text-[20px]"><img
                        src="/images/icons/confirmation.png" alt="">ยืนยัน</button>
            </div>
        </div>
        {{-- <div class="product-details flex items-center justify-center p-4">
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
        </div> --}}
    </div>
@endsection

@section('scripts')
    <script>
        function addItem() {
            window.location.href = "/";
        }
    </script>
@endsection
