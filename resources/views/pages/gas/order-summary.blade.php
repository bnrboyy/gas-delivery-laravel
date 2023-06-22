@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/order-summary.css" />
@endsection

@section('sections')
    <div class="container">
        <div class="flex flex-col w-full h-full">
            <div class="flex flex-col w-full h-[10%] p-4 justify-center items-center">
                <div class="flex w-full justify-center items-center gap-2 text-[20px] md:text-[28px]">
                    <figure>
                        <img src="/images/icons/order-sum.png" alt="" style="max-width: 30px">
                    </figure>
                    <p>สรุปรายการสั่งซื้อ</p>
                </div>
                <div class="flex w-full justify-center items-center gap-2 text-[18px] text-[#5c5a5a] md:text-[20px]">
                    <p>เลขคำสั่งซื้อ</p>
                    <p>{{ $order_temp->orders_number }}</p>
                </div>
            </div>
            <div class="flex flex-col md:flex-row w-full h-[80%] gap-2 md:gap-6 md:p-12">
                <div class="flex flex-col w-full h-1/2 pt-2 md:pt-0 md:h-full md:flex-col gap-2 md:w-1/2 bg-white">
                    <div class="flex gap-2 w-full h-[10%] items-center p-2 md:justify-center text-[18px]">
                        <figure>
                            <img src="/images/icons/bike-delivery.png" alt="" style="max-width: 30px">
                        </figure>
                        <p>ข้อมูลการจัดส่ง</p>
                    </div>
                    <div class="flex flex-col h-[90%] w-full items-center justify-center overflow-auto">
                        <div class="flex items-center justify-center w-full h-full">
                            <div class="flex flex-col w-[70%] sm:w-[80%] h-full gap-[5px]">
                                <div class="flex w-full justify-between">
                                    <label for="address">*ที่อยู่:</label>
                                    <figure
                                        class="map flex w-[30px] h-[30px] justify-center items-center bg-white rounded-full border border-black"
                                        style="box-shadow: -5px -5px 20px #fff, 5px 5px 10px #b4c1d5;">
                                        <a href="/map?type=drop&page=ordersummary">
                                            <img src="/images/icons/pin-location2.png" alt=""
                                                style="max-width: 20px">
                                        </a>
                                    </figure>
                                </div>
                                <div class="detail-drop-address w-full text-[14px] sm:text-[16px]">
                                    <p></p>
                                </div>
                                <input id="address" type="text" placeholder="รายละเอียดที่อยู่เพิ่มเติม">
                                <label for="name">*ชื่อ:</label>
                                <input id="name" type="text" placeholder="กรอกชื่อ">
                                <label for="phone">*เบอร์โทร:</label>
                                <input id="phone" type="number" placeholder="กรอกเบอร์โทร"
                                    onkeydown="return event.keyCode !== 69">
                                <label for="second-phone">เบอร์โทรสำรอง (ไม่บังคับ):</label>
                                <input id="second-phone" type="number" placeholder="กรอกเบอร์โทร"
                                    onkeydown="return event.keyCode !== 69">
                                <p>การชำระเงิน</p>
                                <fieldset class="flex gap-4 pb-2" onchange="paymentType()">
                                    <div>
                                        <input type="radio" id="radio-cash" name="drone" value="cash" checked>
                                        <label for="cash">ชำระเงินปลายทาง</label>
                                    </div>

                                    <div>
                                        <input type="radio" id="radio-tranfer" name="drone" value="tranfer">
                                        <label for="tranfer">โอนจ่าย</label>
                                    </div>
                                </fieldset>
                                <div class="w-full">
                                    <div class="upload-slip flex flex-col justify-center items-center w-full h-[150px]"
                                        style="display: none;">
                                        <div class="w-full h-[30px]">
                                            <p>*อัพโหลดสลิป</p>
                                        </div>
                                        <div class="flex flex-col w-full py-2 h-[220px] justify-center items-center gap-2">

                                            <div
                                                class="slip-area flex justify-center items-center w-[102px] h-1/2 border-dashed border-2 bg-gray-100 border-orange-500 rounded-lg cursor-pointer">
                                                <figure class="w-[50px] h-[50px] rounded-lg overflow-hidden">
                                                    <img src="/images/icons/upload.png" alt="">
                                                </figure>
                                            </div>
                                            <div class="flex w-full gap-2 justify-center items-center h-1/2">
                                                <div class="flex w-[20%] h-full justify-center items-center">
                                                    <figure class="w-[60px] h-[35px]">
                                                        <img src="/images/icons/bankicon1.png" alt="">
                                                    </figure>
                                                </div>
                                                <div class="flex flex-col justify-center items-center h-full w-[70%] ">
                                                    <div class="sm:text-[16px] text-[12px]">
                                                        <p>ธนาคารไทยพาณิชย์</p>
                                                        <p>123-456-7890</p>
                                                        <p>Mr.Nantachi Ruecha</p>
                                                        <input id="bank-id" type="text" name=""
                                                            value="123-456-7891111" style="display: none;">
                                                    </div>
                                                </div>
                                                <div class="flex w-[10%] h-full justify-center items-center">
                                                    <button onclick="copyBankId()"
                                                        class="flex items-center justify-center w-[25px] h-[25px] rounded-full"
                                                        style="box-shadow: -5px -5px 20px #fff, 5px 5px 10px #b4c1d5;">
                                                        <figure class="max-w-[18px]">
                                                            <img src="/images/icons/copy.png" alt="">
                                                        </figure>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col w-full h-1/2 pt-2 md:pt-0 md:h-full md:flex-col gap-2 md:w-1/2 bg-white overflow-auto">
                    <div class="flex gap-2 w-full h-[10%] items-center p-2 md:justify-center text-[18px]">
                        <figure>
                            <img src="/images/icons/order-list.png" alt="" style="max-width: 30px">
                        </figure>
                        <p>รายการทั้งหมด</p>
                    </div>
                    <div class="flex flex-col h-[90%] w-full items-center justify-center overflow-auto">
                        <div class="flex flex-col w-full h-full p-4 gap-2 overflow-auto">
                            @foreach ($order_items as $item)
                                <div class="w-full border-b border-gray-400">
                                    <div class="flex w-full h-[90px] sm:h-[120px]">
                                        <figure class="flex h-full justify-center items-center w-[20%]">
                                            <img src="/{{ $item->thumbnail_link }}" alt="" style="max-width: 70px">
                                        </figure>
                                        <div class="flex flex-col w-[80%] h-full">
                                            <p class="w-full text-gray-500">เปลี่ยนถัง</p>
                                            <p class="w-full text-gray-900 text-[16px]">{{ $item->title }}</p>
                                            <div class="flex justify-between">
                                                <p class="w-full text-gray-900 text-[18px]">ราคา: <span
                                                        class="text-[20px] text-blue-400">{{ $item->price }} บาท</span>
                                                </p>
                                                <p class="text-[20px] text-blue-400">X{{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{-- <div class="w-full border-b border-gray-400">
                                <div class="flex w-full h-[90px] sm:h-[120px]">
                                    <figure class="flex h-full justify-center items-center w-[20%]">
                                        <img src="/images/gas/gas-cylinder.png" alt="" style="max-width: 70px">
                                    </figure>
                                    <div class="flex flex-col w-[80%] h-full">
                                        <p class="w-full text-gray-500">สั่งสินค้า</p>
                                        <p class="w-full text-gray-900 text-[16px]">ถัง 18 KG. สีแดง ขนาด...</p>
                                        <div class="flex justify-between">
                                            <p class="w-full text-gray-900 text-[18px]">ราคา: <span
                                                    class="text-[20px] text-blue-400">150 บาท</span></p>
                                            <p class="text-[20px] text-blue-400">X1</p>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="flex flex-col w-full h-[65px] sm:h-[80px] p-2">
                            <div class="total-price-product flex justify-between w-full text-[14px] sm:text-[18px]"
                                total-price-product="{{ $total_price }}">
                                <p>ราคาสินค้า</p>
                                <p>{{ $total_price }} บาท</p>
                            </div>
                            <div class="delivery-price flex justify-between w-full text-[14px] sm:text-[18px]">
                                <p>ค่าจัดส่ง</p>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="btn-action flex flex-col w-full justify-center items-center h-[10%] border-t-[1px] border-t-gray-400 text-[18px]">
                <div class="flex w-full h-1/2 items-center justify-center gap-8">
                    <div class="w-[332px] h-full flex items-center justify-between px-2 font-bold">
                        <p>ราคารวม</p>
                        <p class="total-price" total-price="{{ $total_price }}"></p>
                    </div>
                </div>
                <div class="flex w-full h-1/2 justify-center items-center gap-8 mb-2 px-2">
                    <button onclick="onCancelOrder('{{ $order_temp->orders_number }}')" class="w-[150px] h-[98%] md:h-full border border-[#e28f21] rounded-md">ยกเลิก</button>
                    <button onclick="confirmOrder()"
                        class="w-[150px] h-[98%] md:h-full bg-[#e28f21] shadow-lg shadow-[#000]-500/40 border border-orange-400 rounded-md">ยืนยันคำสั่งซื้อ</button>
                </div>

            </div>
        </div>
    </div>
    <div class="web-info hidden" price-per-kilo="{{ $price_per_kilo }}" delivery-price="{{ $delivery_price }}"
        maximum-radius="{{ $maximum_radius }}" orders-number="{{ $order_temp->orders_number }}"></div>
@endsection

@section('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYXs0euMCEZ7Um37NqJfu8r9RkT5qlYk8&libraries=geometry,marker,places&callback=initMap&v=weekly"
        defer></script>
    <script src="/js/pages/gas/ordersummary.js?v={{ time() }}"></script>
@endsection
