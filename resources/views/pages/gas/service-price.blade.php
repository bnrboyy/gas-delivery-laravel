@extends('layouts.auth-layout')

@section('style')
    <link rel="styesheet" href="/css/auth.css" />
    <style>

    </style>
@endsection

@section('sections')
    <div class="container">
        <div class="w-full h-full flex flex-col">
            <div class="tiitle flex items-center w-full h-[90px] p-4 text-[2rem]">
                <p class="">ราคาค่าบริการ</p>
            </div>
            <div class="content w-full h-full flex justify-center bg-white p-8">
                <div class="p-5 h-full w-full ">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="p-3 text-sm font-semibold tracking-wide text-left">No.</th>
                                <th class="p-3 text-sm font-semibold tracking-wide text-left">No.</th>
                                <th class="p-3 text-sm font-semibold tracking-wide text-left">No.</th>
                                <th class="p-3 text-sm font-semibold tracking-wide text-left">No.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white">
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                            </tr>
                            <tr class="bg-white">
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                            </tr>
                            <tr class="bg-white">
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                                <td class="p-3 text-sm text-gray-700">sdf</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection
