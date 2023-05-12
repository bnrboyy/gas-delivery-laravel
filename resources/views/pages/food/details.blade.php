@extends('layouts.main-layout')

@section('sections')
    <section id="dish">
        <div class="dish">
            <div class="dish-item">
                <div class="dish-item-image">
                    <figure class="dish-item-image-dishimg">
                        <img src="/{{ $product->thumbnail_link }}" alt="{{ $product->thumbnail_alt }}" />
                    </figure>
                    <figure class="dish-item-image-shadow">
                        <img src="/img/dish/shadow.png" alt="shadowImage" />
                    </figure>
                </div>
                <div class="dish-item-content">
                    <div class="dish-item-content-title">
                        <p>{{ $product->title }}</p>
                    </div>
                    <div class="dish-item-content-address">
                        <div class="dish-item-content-address-title">
                            <figure>
                                <img src="/img/dish/addresspin.png" alt="pinIcon" />
                            </figure>
                            <p>{{ $content_language['9vfWGKhNbMmSNLn'] }}</p>
                        </div>
                        <div class="dish-item-content-address-description">
                            <p>
                                {{ $product->details }}
                            </p>
                        </div>
                        <div class="dish-item-content-address-price" product-price="{{ $product->price }}">
                            <p>{{ $product->price }} {{ $currency_symbol }}</p>
                        </div>
                    </div>
                </div>

                @if ($product->can_wave)
                    <div class="dish-item-microwave">
                        <div class="dish-item-microwave-box">
                            <div class="dish-item-microwave-box-title">
                                <p>{{ $microwave[0]->type }}</p>
                            </div>
                            <div class="dish-item-microwave-box-description">
                                <p>{{ $microwave[0]->details }}</p>
                            </div>
                            <div class="dish-item-microwave-box-temp">
                                <div class="dish-item-microwave-box-temp-button">
                                    @foreach ($microwave as $key => $wave)
                                        <button data-id="{{ $wave->id }}" class="{{ $key === 0 ? 'active' : '' }}">
                                            <figure>
                                                <img src="/img/dish/pick.png" alt="pickIcon" />
                                            </figure>
                                            {{ $wave->name }}
                                        </button>
                                    @endforeach
                                </div>
                                <div class="dish-item-microwave-box-temp-input">
                                    <input type="text" name="requirements"
                                        placeholder="Requirements : Loremaa ipsum dolor sit amet dulo zen in dit nope..." />
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($product->can_sweet)
                    <div class="bottle-item-sweetness">
                        <div class="bottle-item-sweetness-box">
                            <div class="bottle-item-sweetness-box-title">
                                <p>{{ $sweetness[0]->type }}</p>
                            </div>
                            <div class="bottle-item-sweetness-box-description">
                                <p>{{ $sweetness[0]->details }}</p>
                            </div>
                            <div class="bottle-item-sweetness-box-temp">
                                <div class="bottle-item-sweetness-box-temp-button">
                                    @foreach ($sweetness as $key => $sweet)
                                        <button data-id="{{ $sweet->id }}" class="{{ $key === 0 ? 'active' : '' }}">
                                            <figure>
                                                <img src="/img/bottle/pick.png" alt="pickIcon" />
                                            </figure>
                                            {{ $sweet->name }}
                                        </button>
                                    @endforeach
                                </div>
                                <div class="bottle-item-sweetness-box-temp-input">
                                    <input type="text" name="requirements"
                                        placeholder="Requirements : Loremtt ipsum dolor sit amet dulo zen in dit nope..." />
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="dish-item-microwave-box-temp-input"
                        style="width: 100%; max-width:480px; margin: 0 auto; padding: 0 1.5rem;">
                        <input type="text" name="requirements"
                            placeholder="Requirements : Loremff ipsum dolor sit amet dulo zen in dit nope..." />
                    </div>
                @endif

                <div class="dish-item-quantity">
                    <div class="dish-item-quantity-box">
                        <button onclick="minusQuantity()" class="dish-item-quantity-box-left">
                            <figure>
                                <img src="/img/dish/minus.png" alt="minusIcon" />
                            </figure>
                        </button>
                        <div class="dish-item-quantity-box-mid">
                            <p>{{ $content_language['Q3PcqJGe9tbPH15'] }}</p>
                            <div class="dish-item-quantity-box-mid-number">
                                <p id="quantity">0</p>
                            </div>
                        </div>
                        <button onclick="plusQuantity()" class="dish-item-quantity-box-right">
                            <figure>
                                <img src="/img/dish/plus.png" alt="plusIcon" />
                            </figure>
                        </button>
                    </div>
                </div>
                <div class="dish-item-button">
                    <button onclick="addToCart({{ $product->id }})" class="dish-item-button-content"
                        prev-id="{{ $product->cate_id }}">
                        <div class="dish-item-button-content-left">
                            <figure>
                                <img src="/img/dish/carticon.png" alt="cartIcon" />
                            </figure>
                            <p>{{ $content_language['RyXtgXIWNjciCAN'] }}</p>
                        </div>
                        <div class="dish-item-button-content-right">
                            <p>{{ $content_language['yC2SXD73c5EJdak'] }}</p>
                            <b>0 {{ $currency_symbol }}</b>
                        </div>
                    </button>
                    <input id="currency" type="hidden" value="{{ $currency_symbol }}">
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/foods/details.js"></script>
@endsection
