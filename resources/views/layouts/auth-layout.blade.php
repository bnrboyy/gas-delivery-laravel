<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/layout.css" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    @yield('style')
    <title>Gas Delivery</title>
    @yield('style')
</head>

<body>
    <div class="nav-layout">
        <nav class="bg-gray-900 border-gray-200 dark:bg-gray-900">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="/" class="flex items-center">
                    <img src="/images/logo/gas-logo.png" class="h-10 mr-0" alt="gas-logo" />
                    <span class="self-center text-xl font-semibold whitespace-nowrap text-white">GAS DELIVERY</span></a>
                <div class="flex items-center md:order-2">
                    <div class="btn-cart">
                        <button type="button" data-dropdown-toggle="language-dropdown-menu" onclick="goToCart()"
                            class="lang-button inline-flex items-center font-medium justify-center px-4 py-2 text-sm text-white dark:text-white rounded-lg cursor-pointer hover:bg-gray-700 dark:hover:bg-gray-700 dark:hover:text-white">
                            <p style="font-size: 18px">ตะกร้า</p>
                            <img class="rounded-full mr-1 w-7" src="/images/icons/add-to-cart.png" alt="">
                        </button>
                        <div class="cart-notify">{{$cart_notify}}</div>
                    </div>

                    <!-- Dropdown -->
                    <div class="lang-dropdown z-50 hidden my-4 text-base list-none bg-gray-700 divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        {{-- <ul class="py-2 font-medium" role="none">
                            @foreach ($language_available as $lang)
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem" onclick="changeLanguage('{{ $lang->abbv_name }}')">
                                        <div class="inline-flex items-center">
                                            <img class="rounded-full mr-1 w-7" src="{{ $lang->flag }}" alt="">
                                            {{ $lang->name }}
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul> --}}
                    </div>
                    <button data-collapse-toggle="mobile-menu-language-select" type="button"
                        class="menu-language-button inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="mobile-menu-language-select" aria-expanded="true">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" fill="currentColor" aria-hidden="true" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="menu-language items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
                    id="mobile-menu-language-select">
                    <ul
                        class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-700 rounded-lg bg-gray-800 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-gray-900 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        <li>
                            <a href="/"
                                class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-blue-500 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                aria-current="page">หน้าหลัก</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-blue-500 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">บริการ</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-blue-500 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">ราคาค่าบริการ</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-blue-500 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">ติดต่อเรา</a>
                        </li>
                        <li>
                            <a href="/searchorder"
                                class="flex gap-[3px] py-2 pl-3 pr-4 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-blue-500 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"><img src="/images/icons/search.png" alt="" style="max-width: 25px;">คำสั่งซื้อ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <main>
        @yield('sections')
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"
        integrity="sha512-LUKzDoJKOLqnxGWWIBM4lzRBlxcva2ZTztO8bTcWPmDSpkErWx0bSP4pdsjNH8kiHAUPaT06UXcb+vOEZH+HpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // var loader = document.getElementById("loader");
        // window.addEventListener("load", function() {
        //     loader.style.display = "none";
        // });
        const langBtn = document.querySelector('.lang-button')
        const langMenuBtn = document.querySelector('.menu-language-button')
        langBtn.addEventListener('click', function() {
            const langDropdown = document.querySelector('.lang-dropdown')
            langDropdown.classList.toggle('show')
        })
        langBtn.addEventListener('blur', function() {
            const langDropdown = document.querySelector('.lang-dropdown')
            setTimeout(() => {
                langDropdown.classList.remove('show')
            }, 300);
        })
        langMenuBtn.addEventListener('click', function() {
            const langMenu = document.querySelector('.menu-language')
            langMenu.classList.toggle('show')
        })

        function changeLanguage(lang) {
            location.href = `/changeLanguage?lang=${lang}`
        }

        function goToCart() {
            if (window.location.pathname === "/cart") return false;
            window.location.href = "/cart";
        }

    </script>
    @yield('scripts')
</body>

</html>
