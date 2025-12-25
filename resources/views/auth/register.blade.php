@extends('layouts.guest')

@section('content')
<div class="flex w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[600px]">

    <!-- Left Side - Login" -->
    <div class="hidden lg:flex lg:w-1/2 p-12 flex-col justify-center items-center text-white relative overflow-hidden min-h-full"
        style="background-image: url('{{ asset(path: 'authpic.jpg') }}'); background-size: cover; background-position: center;">

    <!-- Blur sama Dark overlay -->
    <div class="absolute inset-0 backdrop-blur-sm"></div>
    <div class="absolute inset-0 bg-black opacity-40"></div>

        <div class="relative z-10 text-center">
            <h1 class="text-5xl font-bold mb-6">Udah Punya Akun?</h1>
            <p class="text-lg text-blue-100">Masuk dulu, yuk</p>
            <p class="text-lg text-blue-100 mb-4">Banyak barang menarik nungguin kamu.</p>


            <a href="{{ route('login') }}"
                class="inline-block border-2 border-white text-white font-semibold px-12 py-3 rounded-full hover:bg-white hover:text-black transition">
                MASUK
            </a>
        </div>
    </div>

    <!-- Right Side - Register -->
    <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center min-h-full">
        <div class="max-w-md mx-auto">
            <h2 class="text-4xl font-bold text-gray-800 mb-2">Daftar Akun</h2>
            <p class="text-gray-500 mb-6">Daftar untuk lanjut cari barang favoritmu</p>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 p-3 rounded-lg">
                    <ul class="text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.process') }}">
                @csrf

                <input type="text" name="name" placeholder="Nama" required
                    class="w-full mb-4 px-4 py-3 bg-gray-100 rounded-lg">

                <input type="email" name="email" placeholder="Email" required
                    class="w-full mb-4 px-4 py-3 bg-gray-100 rounded-lg">

                <input type="password" name="password" placeholder="Kata Sandi" required
                    class="w-full mb-4 px-4 py-3 bg-gray-100 rounded-lg">

                <input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required
                    class="w-full mb-6 px-4 py-3 bg-gray-100 rounded-lg">

                <button type="submit"
                    class="w-full bg-black text-white font-bold py-3 rounded-full hover:bg-gray-700 transition">
                    DAFTAR
                </button>

            </form>
        </div>
    </div>
</div>
@endsection
