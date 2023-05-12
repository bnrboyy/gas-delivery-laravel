@extends('layouts.main-layout')

@section('sections')
    <section id="receipt">

        <div class="slip">
            <div class="slip-item">

                @include('layouts.banner')

                <div class="slip-item-content">
                    <figure class="slip-item-content-image">
                        <img src="/{{ $payment->slip_image }}" alt="slipImage">
                    </figure>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/profile/receipt.js"></script>
@endsection
