@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/product-details.css">
@endsection

@section('sections')
    <div class="container">
        <div class="product-details flex items-center justify-center p-4">
            <div class="details flex w-full items-center p-2 gap-2">
                <div class="card-item">
                    <div class="content-head">
                        <img src="/{{ $data->thumbnail_link }}" alt="">
                    </div>
                    <div class="box-details-action w-full">
                        <button class="btn-decrement w-6 h-6">
                            <figure>
                                <img src="/images/icons/minus.png" alt="">
                            </figure>
                        </button>
                        <div class="show-quantity">
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
                <div class="details-item flex flex-col gap-2">
                    <div class="box-details w-full ">
                        <p class="text-[18px]"><span class="text-gray-500">[{{ $cate_title }}] : </span> {{ $data->title }} </p>
                        <div class="w-full break-all">
                            <p class="">{{ $data->details }}</p>
                        </div>
                    </div>
                    <div class="flex w-full h-[80px]">
                        <input class="w-full" type="text" placeholder="รายละเอียดเพิ่มเติม">
                    </div>
                    <div class="box-details-action product-price w-full" productPrice="{{ $data->price }}">
                        <p>ราคารวม: <span style="color: #0170fa;">{{ $data->price }} บาท</span> </p>

                        <button onclick="addToCart({{ $data->id }})" class="btn-addToCart">เพิ่มสินค้า</button>
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

        const productPrice = parseInt(document.querySelector(".product-price").getAttribute("productPrice"))
        const totalShow = document.querySelector(".box-details-action span")
        let totalPrice = productPrice;
        let quantity = 1;

        btn_decrement.addEventListener('click', () => {
            if (parseInt(show_number.innerText) === 1) return false;
            show_number.innerHTML = `${parseInt(show_number.innerText) - 1}`;
            totalPrice = totalPrice - productPrice;
            totalShow.innerHTML = totalPrice + " บาท"
            quantity--;
        })
        btn_increment.addEventListener('click', () => {
            if (parseInt(show_number.innerText) === 5) return false;
            show_number.innerHTML = `${parseInt(show_number.innerText) + 1}`;
            totalPrice = totalPrice + productPrice;
            totalShow.innerHTML = totalPrice + " บาท"
            quantity++;
        })

        function addToCart(_id) {
            const data = {
                p_id: _id,
                quantity: quantity,
                requirements: '',
            }

            axios.post('/create/ordertemp', data).then((result) => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'เพิ่มสินค้าสำเร็จ',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = "/cart";
                })
            }).catch((err) => {
                console.log(err)
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                })
            });

        }
    </script>
@endsection
