@extends('layouts.main-layout')

@section('sections')
    <section id="evidence">

        <div class="slip">
            <div class="slip-item">

                @include('layouts.banner')

                <div class="slip-item-content">
                    <figure class="slip-item-content-image">
                        <img src="/{{ $order->drop_image }}" alt="evidenceImage1">
                    </figure>
                    <figure class="slip-item-content-image">
                        <img src="/{{ $order->pickup_image }}" alt="evidenceImage2">
                    </figure>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/profile/receipt.js"></script>
@endsection
