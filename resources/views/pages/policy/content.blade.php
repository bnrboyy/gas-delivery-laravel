@extends('layouts.main-layout')

@section('sections')
    <section id="termOfService">

        <div class="tos">
            <div class="tos-item">

                @include('layouts.banner')
                <div class="tos-item-content">
                    <div class="tos-item-content-title">
                        <p>{{ $content->description }}</p>
                    </div>
                    <div class="tos-item-content-description">
                        {!! $content->content !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/termofservice.js"></script>
@endsection
