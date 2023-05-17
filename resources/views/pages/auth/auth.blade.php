@extends('layouts.auth-layout')

@section('style')
    <link rel="stylesheet" href="/css/auth.css" />
@endsection

@section('sections')
    <section id="index">
        {{-- <div class="index" style="overflow:auto">
            <div class="index-item">
                <div class="index-item-logo">
                    <figure class="index-item-logo-mainlogo">
                        <img src="/img/home/mainlogogroup.png" alt="MainLogo" />
                    </figure>
                    <figure class="index-item-logo-textlogo">
                        <img src="/img/home/textlogo1.png" alt="TextLogo1" />
                        <img src="/img/home/textlogo2.png" alt="TextLogo2" />
                    </figure>
                </div>
                <div class="index-item-button">
                    <button class="index-item-button-washndry"><a href="/washing">{{$content_language['Cq9xdCyinuQ4M08']}}</a></button>
                    <button class="index-item-button-vendingncafe"><a href="/foods">{{$content_language['p7NhmzzCKEZHr5a']}}</a></button>
                    @auth('member')
                        <div class="home-item-user">
                            <figure class="home-item-user-icon" onclick="location.href='/profile'">
                                <a href="/profile"><img src="/{{ isset($member->profile_image) ? $member->profile_image : 'img/home/user.png' }}"
                                alt="userIcon" style="{{ isset($member->profile_image) ? 'height:100%;' : '' }}"></a>
                            </figure>
                            <div class="home-item-user-notice">
                                <p>Welcome Back</p>
                            </div>
                            <div class="home-item-user-name">
                                <p>{{ Auth::guard('member')->user()->member_name }}</p>
                            </div>
                        </div>
                    @endauth
                    @guest('member')
                        <div class="index-item-button-line"></div>
                        <button class="index-item-button-login"><a href="/auth/auth-login">LOGIN</a></button>
                    @endguest
                </div>
                <div class="index-item-language">
                    <div class="flex justify-end w-[6rem]">
                        <p class="">{{$content_language['3HgYorJLAMxNleL']}}</p>
                    </div>
                    <img src="{{$language_active->flag}}" alt="">
                    <div class="relative inline-block w-[6rem]">
                        <button type="button"
                            class="lang-button inline-flex w-full justify-left gap-x-1.5 rounded-md"
                            id="menu-button" aria-expanded="true" aria-haspopup="true">
                            {{$language_active->name}}
                            <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="lang-dropdown absolute right-[20px] z-10 mt-4 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                @foreach ($language_available as $lang)
                                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem"
                                    tabindex="-1" onclick="changeLanguage('{{$lang->abbv_name}}')">{{$lang->name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="index-item-footer">
                    <div class="index-item-footer-link">
                        <a href="/content/termofservice">{{$content_language['3yRRcWdpAevbBQz']}}</a>
                        <a href="/content/privacypolicy">{{$content_language['9o3ier2Fyu5Nscp']}}</a>
                    </div>
                    <div class="index-item-footer-copyright">
                        <p>Copyright © 2020-2023 Manami Vending Cafe. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div> --}}

        <nav class="bg-white border-gray-200 dark:bg-gray-900">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="https://flowbite.com/" class="flex items-center">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
                </a>
                <div class="flex items-center md:order-2">
                    <button type="button" data-dropdown-toggle="language-dropdown-menu"
                        class="lang-button inline-flex items-center font-medium justify-center px-4 py-2 text-sm text-gray-900 dark:text-white rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5 mr-2 rounded-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3900 3900">
                            <path fill="#b22234" d="M0 0h7410v3900H0z" />
                            <path d="M0 450h7410m0 600H0m0 600h7410m0 600H0m0 600h7410m0 600H0" stroke="#fff"
                                stroke-width="300" />
                            <path fill="#3c3b6e" d="M0 0h2964v2100H0z" />
                            <g fill="#fff">
                                <g id="d">
                                    <g id="c">
                                        <g id="e">
                                            <g id="b">
                                                <path id="a"
                                                    d="M247 90l70.534 217.082-184.66-134.164h228.253L176.466 307.082z" />
                                                <use xlink:href="#a" y="420" />
                                                <use xlink:href="#a" y="840" />
                                                <use xlink:href="#a" y="1260" />
                                            </g>
                                            <use xlink:href="#a" y="1680" />
                                        </g>
                                        <use xlink:href="#b" x="247" y="210" />
                                    </g>
                                    <use xlink:href="#c" x="494" />
                                </g>
                                <use xlink:href="#d" x="988" />
                                <use xlink:href="#c" x="1976" />
                                <use xlink:href="#e" x="2470" />
                            </g>
                        </svg>
                        {{ $language_active->name }}
                    </button>
                    <!-- Dropdown -->
                    <div class="lang-dropdown z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <ul class="py-2 font-medium" role="none">
                            @foreach ($language_available as $lang)
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">
                                        <div class="inline-flex items-center">
                                            <img class="rounded-full mr-1" src="{{ $lang->flag }}" alt="">
                                            {{$lang->name}}
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            {{-- <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">
                                    <div class="inline-flex items-center">
                                        <svg class="h-3.5 w-3.5 rounded-full mr-2" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-de" viewBox="0 0 512 512">
                                            <path fill="#ffce00" d="M0 341.3h512V512H0z" />
                                            <path d="M0 0h512v170.7H0z" />
                                            <path fill="#d00" d="M0 170.7h512v170.6H0z" />
                                        </svg>
                                        Deutsch
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">
                                    <div class="inline-flex items-center">
                                        <svg class="h-3.5 w-3.5 rounded-full mr-2" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-it"
                                            viewBox="0 0 512 512">
                                            <g fill-rule="evenodd" stroke-width="1pt">
                                                <path fill="#fff" d="M0 0h512v512H0z" />
                                                <path fill="#009246" d="M0 0h170.7v512H0z" />
                                                <path fill="#ce2b37" d="M341.3 0H512v512H341.3z" />
                                            </g>
                                        </svg>
                                        Italiano
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">
                                    <div class="inline-flex items-center">
                                        <svg class="h-3.5 w-3.5 rounded-full mr-2" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            id="flag-icon-css-cn" viewBox="0 0 512 512">
                                            <defs>
                                                <path id="a" fill="#ffde00" d="M1-.3L-.7.8 0-1 .6.8-1-.3z" />
                                            </defs>
                                            <path fill="#de2910" d="M0 0h512v512H0z" />
                                            <use width="30" height="20" transform="matrix(76.8 0 0 76.8 128 128)"
                                                xlink:href="#a" />
                                            <use width="30" height="20"
                                                transform="rotate(-121 142.6 -47) scale(25.5827)" xlink:href="#a" />
                                            <use width="30" height="20"
                                                transform="rotate(-98.1 198 -82) scale(25.6)" xlink:href="#a" />
                                            <use width="30" height="20"
                                                transform="rotate(-74 272.4 -114) scale(25.6137)" xlink:href="#a" />
                                            <use width="30" height="20"
                                                transform="matrix(16 -19.968 19.968 16 256 230.4)" xlink:href="#a" />
                                        </svg>
                                        中文 (繁體)
                                    </div>
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                    <button data-collapse-toggle="mobile-menu-language-select" type="button"
                        class="menu-language-button inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
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
                        class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Pricing</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </section>
@endsection

@section('scripts')
    <script>
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
            // axios
            // .get(`/api-member/language/${lang}`)
            // .then((response) => {
            //     location.reload();
            // })
        }
    </script>
@endsection
