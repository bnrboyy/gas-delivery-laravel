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
                                        <button class="btn-decrement w-6 h-6"
                                            onclick="decrementNumb('{{ $item->id }}', '{{ $item->quantity - 1 }}', '{{ $item->quantity }}')">
                                            <figure>
                                                <img style="max-width: 18px" src="/images/icons/minus.png" alt="">
                                            </figure>
                                        </button>
                                        <div class="show-quantity">
                                            <div class="show-quantity-number">
                                                <p class="text-[22px]">{{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                        <button class="btn-increment w-6 h-6"
                                            onclick="incrementNumb('{{ $item->id }}', '{{ $item->quantity + 1 }}', '{{ $item->quantity }}')">
                                            <figure>
                                                <img style="max-width: 18px;" src="/images/icons/plus.png" alt="">
                                            </figure>
                                        </button>
                                    </div>
                                </div>

                                <div class="box-details-action flex flex-col items-center w-[15%]">
                                    <button
                                        onclick="onDelete('{{ $order_temp->orders_number }}', '{{ $item->product_id }}', '{{ $item->id }}')">
                                        <img src="/images/icons/delete2.png" alt="" style="max-width: 30px">
                                    </button>
                                </div>

                            </div>

                        </div>
                    @endforeach
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
        function incrementNumb(_id, _newQuantity, _quantity) {
            if (parseInt(_quantity) === 5) return false;
            axios.get(`/cart/item/updatequantity/${_id}?quantity=${_newQuantity}`).then((res) => {
                console.log(res.data)
                window.location.reload();
            }).catch((err) => console.log(err))
        }

        function decrementNumb(_id, _newQuantity, _quantity) {
            if (parseInt(_quantity) === 1) return false;
            axios.get(`/cart/item/updatequantity/${_id}?quantity=${_newQuantity}`).then((res) => {
                console.log(res.data)
                window.location.reload();
            }).catch((err) => console.log(err))
        }

        function addItem() {
            window.location.href = "/";
        }

        function toConfirmOrder() {
            window.location.href = "/ordersummary"
        }

        function onDelete(_orderNumber, p_id, _id) {
            Swal.fire({
                text: "คุณต้องการลบสินค้าออกจากตะกร้าหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ลบ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/orderitem/delete?ordernumber=${_orderNumber}&pid=${p_id}&id=${_id}`)
                        .then(() => {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'ลบสินค้าสำเร็จ',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.reload();
                            })
                        }).catch((err) => console.log(err))
                }
            })
        }
    </script>
@endsection
