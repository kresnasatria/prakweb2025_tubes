@extends('layouts.guest')

@section('content')
<div class="flex w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[600px]">

    <!-- Left Side - Welcome Section -->
    <div class="hidden lg:flex lg:w-1/2 p-12 flex-col justify-center items-center text-white relative overflow-hidden min-h-full"
        style="background-image: url('{{ asset('authpic.jpg') }}'); background-size: cover; background-position: center;">

        <div class="absolute top-0 left-0 w-64 h-64 bg-black opacity-20 rounded-full -translate-x-32 -translate-y-32"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-black opacity-20 rounded-full translate-x-32 translate-y-32"></div>
        <div class="absolute inset-0 bg-black opacity-40"></div>

        <div class="relative z-10 text-center">
            <h1 class="text-5xl font-bold mb-6">Welcome to Our Store</h1>
            <p class="text-lg text-blue-100 mb-8">Create your account to start shopping with us</p>

            <a href="{{ route('register') }}"
               class="inline-block border-2 border-white text-white font-semibold px-12 py-3 rounded-full hover:bg-white hover:text-blue-600 transition-all duration-300">
                REGISTER
            </a>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center min-h-full">
        <div class="max-w-md mx-auto">
            <h2 class="text-4xl font-bold text-gray-800 mb-2">Sign In</h2>
            <p class="text-gray-500 mb-8">Access your account to continue shopping</p>

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                <div class="mb-4">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6 relative">
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-3 rounded-full hover:bg-blue-700 transition">
                    SIGN IN
                </button>

                <div class="mt-6 text-center lg:hidden">
                    <a href="{{ route('register') }}" class="text-blue-600 font-medium">
                        Don't have an account? Register
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
