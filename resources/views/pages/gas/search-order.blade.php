@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="">
@endsection

@section('sections')
    <div class="container flex-col" style="align-items: start !important;">
        <div class="flex flex-col md:flex-row w-full h-[17%] sm:h-[13%] gap-2 p-4">
            <div class="flex md:justify-start justify-center items-center gap-2 w-full md:w-1/2 h-full text-[20px] md:text-[24px]">
                <figure class="w-[20px] md:w-[30px] h-[20px] md:h-[30px]">
                    <img src="/images/icons/list.png" alt="">
                </figure>
                <p>รายการคำสั่งซื้อ</p>
            </div>
            <div class="flex justify-center md:justify-end items-center gap-2 w-full md:w-1/2 h-full">
                <input onkeydown="return event.keyCode !== 69" class="input-phone border border-none rounded h-[30px] md:h-[40px]" type="number" placeholder="กรอกเบอร์โทร" style="box-shadow: 4px 4px 10px #b4c1d5; border: none; border-radius: 0.25rem;">
                <button onclick="searchOrder()" class="w-[30px] md:w-[40px] h-[30px] md:h-[40px] bg-white rounded p-2" style="box-shadow: 4px 4px 10px #b4c1d5;">
                    <figure>
                        <img src="images/icons/magnifying-glass.png" alt="">
                    </figure>
                </button>
            </div>
        </div>
        <div class="w-full h-[87%] p-4 bg-white overflow-auto">
            @if (count($order_details) === 0)
                <div class="flex items-center justify-center w-full">
                    <div class="flex items-center justify-center w-1/2 min-w-[300px] h-[6rem] rounded-xl text-[2rem]" style="box-shadow: 5px 5px 10px #b4c1d5;">
                        <p class="text-gray-500">ไม่มีคำสั่งซื้อ</p>
                    </div>

                </div>
            @endif
            <div class="flex flex-col md:flex-wrap md:flex-row w-full h-full">
                @foreach ($order_details as $order_detail)
                    <div class="flex justify-center items-center min-h-[623px] md:w-1/2 p-4">
                        <div class="flex flex-col gap-2 w-full max-w-[450px] h-full p-4 rounded-xl" style="box-shadow: 5px 5px 10px #b4c1d5;">
                            <div class="flex flex-col w-full h-[60px]">
                                <div class="flex w-full items-center justify-between">
                                    <div class="flex gap-2">
                                        <img src="images/icons/calendar.png" alt="" width="30">
                                        <p class="text-gray-500 text-[16px]">วันที่ทำรายการ:</p>
                                    </div>
                                    <a href="#">
                                        <img src="images/icons/line.png" alt="" width="35">
                                    </a>
                                </div>
                                <p class="text-[18px]">{{$order_detail->transaction_date}}</p>
                            </div>
                            <div class="flex flex-col w-full h-[60px]">
                                <div class="flex gap-2 w-full items-center">
                                    <img src="images/icons/clipboard.png" alt="" width="30">
                                    <p class="text-gray-500 text-[16px]">สถานะ:</p>
                                </div>
                                @if ($order_detail->status_id == 4)
                                    <div class="flex w-full gap-2 ml-8">
                                        <img src="images/icons/check-success.png" alt="" width="30">
                                        <p class="text-[18px] text-[#2ebf21]">{{ $order_detail->order_status }}</p>
                                    </div>
                                @else
                                    <p class="text-[18px]">{{ $order_detail->order_status }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col w-full h-[60px]">
                                <div class="flex gap-2 w-full items-center">
                                    <img src="images/icons/tracking.png" alt="" width="30">
                                    <p class="text-gray-500 text-[16px]">เลขคำสั่งซื้อ:</p>
                                </div>
                                <p class="text-[18px]">{{$order_detail->orders_number}}</p>
                            </div>
                            <div class="flex flex-col w-full h-[60px]">
                                <div class="flex gap-2 w-full items-center">
                                    <img src="images/icons/time-left.png" alt="" width="30">
                                    <p class="text-gray-500 text-[16px]">ระยะเวลาจัดส่ง:</p>
                                </div>
                                <p class="text-[18px]">20 - 40 นาที โดยประมาณ</p>
                            </div>
                            <div class="flex flex-col w-full h-[60px] overflow-auto">
                                <div class="flex gap-2 w-full items-center">
                                    <img src="images/icons/pin.png" alt="" width="30">
                                    <p class="text-gray-500 text-[16px]">สถานที่จัดส่ง:</p>
                                </div>
                                <p class="text-[14px] md:text-[18px]">{{$order_detail->delivery_drop_address}}</p>
                            </div>
                            <div class="flex gap-2 w-full items-center">
                                <img src="images/icons/check-list.png" alt="" width="30">
                                <p class="text-gray-500 text-[16px]">รายการสั่งซื้อ:</p>
                            </div>
                            <div class="flex flex-col w-full h-[200px] gap-2 overflow-auto border boder-black">
                                @foreach ($order_detail->order_items as $key => $item)
                                    <div class="w-full h-[80px] p-2 ">
                                        <div class="flex w-full h-[80px] border-b border-black">
                                            <div class="flex justify-center items-center w-[20%] min-w-[70px] h-full">
                                                <figure class="max-w-full p-2">
                                                    <img src="{{$item->product_img}}" alt="">

                                                </figure>
                                            </div>
                                            <div class="flex flex-col w-[80%] h-full">
                                                <p>[{{$item->product_cate_id == 1 ? "เปลี่ยนถัง" : ($item->product_cate_id == 2 ? "ถังแก๊สใหม่" : "อุปกรณ์")}}]</p>
                                                <div class="flex w-full justify-between">
                                                    <p>{{$item->product_name}}</p>
                                                    <p>X{{$item->quantity}}</p>
                                                </div>
                                                <p>ราคา {{$item->product_price}} บาท</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($order_detail->discount !== 0)
                                <div class="flex flex-col w-full h-[60px]">
                                    <div class="flex gap-2 w-full items-center">
                                        <img src="images/icons/tag.png" alt="" width="30">
                                        <p class="text-gray-500 text-[16px]">ส่วนลดจากร้านค้า:</p>
                                    </div>
                                    <p class="text-[18px]">{{$order_detail->discount}} บาท</p>
                                </div>
                            @endif
                            <div class="flex flex-col w-full h-[60px]">
                                <div class="flex gap-2 w-full items-center">
                                    <img src="images/icons/dollar.png" alt="" width="30">
                                    <p class="text-gray-500 text-[16px]">ราคารวม:</p>
                                </div>
                                <p class="text-[18px]">{{($order_detail->total_price + $order_detail->delivery_price) - $order_detail->discount}} บาท (ค่าส่ง {{$order_detail->delivery_price}} บาท)</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        const phone = localStorage.getItem('phone_number');
        const input_phone = document.querySelector('.input-phone')
        input_phone.value = phone ? phone : "";

        function searchOrder() {
            if (input_phone.value === "") return false;

            localStorage.setItem('phone_number', input_phone.value)
            window.location.href = `searchorder?phone=${input_phone.value}`
        }
    </script>
@endsection
