@extends('layouts.main-layout')

@section('sections')
    <section id="editInfo">
        
        <div class="editinfo">
            <div class="editinfo-item">
                
                @include('layouts.banner')

                <div class="editinfo-item-form">
                    <div class="editinfo-item-form-title">
                        <p>Phone Number</p>
                    </div>
                    <div class="editinfo-item-form-input">
                        <input type="text" placeholder="123-456-7890" autofocus>
                    </div>
                    <div class="editinfo-item-form-line"></div>
                </div>
                <div class="editinfo-item-button">
                    <button onclick="infoPage()" class="editinfo-item-button-yeet">CANCEL</button>
                    <button onclick="editInfo()" class="editinfo-item-button-yoink">SAVE</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/pages/profile/informationedit.js"></script>
@endsection
