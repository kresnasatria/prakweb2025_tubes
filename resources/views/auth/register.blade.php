@extends('layouts.guest')

@section('content')
<div class="flex w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[600px]">

    <!-- Left Side -->
    <div class="hidden lg:flex lg:w-1/2 p-12 flex-col justify-center items-center text-white relative overflow-hidden min-h-full"
        style="background-image: url('{{ asset('authpic.jpg') }}'); background-size: cover; background-position: center;">

        <div class="absolute inset-0 bg-black opacity-40"></div>

        <div class="relative z-10 text-center">
            <h1 class="text-5xl font-bold mb-6">Welcome Back</h1>
            <p class="text-lg text-blue-100 mb-8">Sign in to continue shopping</p>

            <a href="{{ route('login') }}"
               class="inline-block border-2 border-white text-white px-12 py-3 rounded-full hover:bg-white hover:text-blue-600 transition">
                SIGN IN
            </a>
        </div>
    </div>

    <!-- Right Side - Register -->
    <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center min-h-full">
        <div class="max-w-md mx-auto">
            <h2 class="text-4xl font-bold text-gray-800 mb-2">Register</h2>
            <p class="text-gray-500 mb-6">Create your account</p>

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

                <input type="text" name="name" placeholder="Name" required
                    class="w-full mb-4 px-4 py-3 bg-gray-100 rounded-lg">

                <input type="email" name="email" placeholder="Email" required
                    class="w-full mb-4 px-4 py-3 bg-gray-100 rounded-lg">

                <input type="password" name="password" placeholder="Password" required
                    class="w-full mb-4 px-4 py-3 bg-gray-100 rounded-lg">

                <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                    class="w-full mb-6 px-4 py-3 bg-gray-100 rounded-lg">

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-3 rounded-full hover:bg-blue-700 transition">
                    SIGN UP
                </button>

                <div class="mt-6 text-center lg:hidden">
                    <a href="{{ route('login') }}" class="text-blue-600 font-medium">
                        Already have an account? Sign In
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
