@extends('layouts.guest')

@section('content')
<div class="flex w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[600px]">

    <!-- Left Side "Registrasi"-->
    <div class="hidden lg:flex lg:w-1/2 p-12 flex-col justify-center items-center text-white relative overflow-hidden min-h-full"
        style="background-image: url('{{ asset('authpic.jpg') }}'); background-size: cover; background-position: center;">

    <!-- Blur sama Dark overlay -->
    <div class="absolute inset-0 backdrop-blur-sm"></div>
    <div class="absolute inset-0 bg-black opacity-40"></div>

        <div class="relative z-10 text-center">
            <h1 class="text-5xl font-bold mb-6">Halo, Selamat Datang</h1>
            <p class="text-lg text-blue-100">Belum punya akun?</p>
            <p class="text-lg text-blue-100 mb-4">Daftar untuk lanjut cari barang favoritmu</p>

            <a href="{{ route('register') }}"
                class="inline-block border-2 border-white text-white font-semibold px-12 py-3 rounded-full hover:bg-white hover:text-black transition">
                DAFTAR
            </a>
        </div>
    </div>

    <!-- Right Side - Login -->
    <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center min-h-full">
        <div class="max-w-md mx-auto">
            <h2 class="text-4xl font-bold text-gray-800 mb-2">Masuk Akun</h2>
            <p class="text-gray-500 mb-8">Masuk dulu, yuk. Banyak barang menarik nungguin kamu.</p>

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="Email"
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">

                    @error('email')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Pass -->
                <div class="mb-6 relative">
                    <input id="password" type="password" name="password" required
                        placeholder="Kata Sandi"
                        class="w-full px-4 py-3 pr-10 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">

                    <button type="button" onclick="togglePassword('password')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>

                    @error('password')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
 
                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-black text-white font-bold py-3 rounded-full hover:bg-gray-700 transition shadow-lg">
                    MASUK
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection
