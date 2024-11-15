@extends('layouts.main')

@section('content')
    <div class="hero min-h-screen"
        style="background-image: url(https://img.daisyui.com/images/stock/photo-1507358522600-9f71e620c44e.webp);">
        <div class="hero-overlay bg-opacity-60"></div>
        <div class="hero-content text-neutral-content text-center">
            <div class="max-w-md">
                <h1 class="mb-5 text-5xl font-bold">Hello there</h1>
                <p class="mb-5">
                    AMBA <br>
                    AMBA Inventory adalah sebuah aplikasi web yang digunakan untuk mengelola sistem inventaris yang dikembangkan perusahaan JMK
                </p>
                <a href="{{ url('/admin') }}">
                    <button class="btn btn-xs sm:btn-sm md:btn-md lg:btn-lg btn-primary">Get Started</button>
                </a>
            </div>
        </div>
    </div>
@endsection
