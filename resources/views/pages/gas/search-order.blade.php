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
                <input onkeydown="return event.keyCode !== 69" class="border-none rounded h-[30px] md:h-[40px]" type="number" placeholder="กรอกเบอร์โทร" style="box-shadow: 4px 4px 10px #b4c1d5;">
                <button class="w-[30px] md:w-[40px] h-[30px] md:h-[40px] bg-white rounded p-2" style="box-shadow: 4px 4px 10px #b4c1d5;">
                    <figure>
                        <img src="images/icons/magnifying-glass.png" alt="">
                    </figure>
                </button>
            </div>
        </div>
        <div class="w-full h-[87%] p-4 bg-white overflow-auto">
            <div class="flex flex-col md:flex-wrap md:flex-row w-full h-full">
                <div class="flex justify-center items-center min-h-[500px] md:w-1/2 p-4">
                    <div class="flex flex-col gap-2 w-full max-w-[450px] h-full p-4 rounded-xl" style="box-shadow: 5px 5px 10px #b4c1d5;">
                        <div class="flex flex-col w-full h-[60px] border border-red-500">
                            <p class="text-gray-500 text-[16px]">วันที่ทำรายการ</p>
                            <p class="text-[18px]">02-06-2023</p>
                        </div>
                        <div class="flex flex-col w-full h-[60px] border border-red-500">
                            <p class="text-gray-500 text-[16px]">สถานะ</p>
                            <p class="text-[18px]">กำลังดำเนินการ</p>
                        </div>
                        <div class="flex flex-col w-full h-[60px] border border-red-500">
                            <p class="text-gray-500 text-[16px]">เลขคำสั่งซื้อ</p>
                            <p class="text-[18px]">ORD-12345667890</p>
                        </div>
                        <div class="flex flex-col w-full h-[60px] border border-red-500">
                            <p class="text-gray-500 text-[16px]">เวลาจัดส่ง</p>
                            <p class="text-[18px]">11:45 น.</p>
                        </div>
                        <div class="flex flex-col w-full h-[60px] border border-red-500">
                            <p class="text-gray-500 text-[16px]">สถานที่จัดส่ง</p>
                            <p class="text-[18px]">บ้านเลขที่ 111/444 เมืองขอนแก่น. . . .</p>
                        </div>
                        <div class="flex flex-col w-full h-[200px] border border-red-500">

                        </div>
                        <div class="flex flex-col w-full h-[60px] border border-red-500">
                            <p class="text-gray-500 text-[16px]">ราคารวม</p>
                            <p class="text-[18px]">250 บาท</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection
