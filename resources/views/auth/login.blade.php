<x-guest-layout>
    <div class="flex w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[600px]">

        <!-- Left Side - Welcome Section -->
        <div class="hidden lg:flex lg:w-1/2 p-12 flex-col justify-center items-center text-white relative overflow-hidden min-h-full"
            style="background-image: url('{{ asset('authpic.jpg') }}'); background-size: cover; background-position: center;">
            <!-- Decorative circles -->
            <div
                class="absolute top-0 left-0 w-64 h-64 bg-black opacity-20 rounded-full -translate-x-32 -translate-y-32">
            </div>
            <div
                class="absolute bottom-0 right-0 w-96 h-96 bg-black opacity-20 rounded-full translate-x-32 translate-y-32">
            </div>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black opacity-40"></div>

            <div class="relative z-10 text-center">
                <h1 class="text-5xl font-bold mb-6">Welcome to Our Store</h1>
                <p class="text-lg text-blue-100 mb-8">Create your account to start shopping with us</p>

                <!-- Sign Up Button -->
                <a href="{{ route('register') }}"
                    class="inline-block border-2 border-white text-white font-semibold px-12 py-3 rounded-full hover:bg-white hover:text-blue-600 transition-all duration-300 cursor-pointer">
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

                    <!-- Email Input -->
                    <div class="mb-4">
                        <input id="email"
                            class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('email') border-red-500 @enderror"
                            type="email" name="email" value="{{ old('email') }}" placeholder="Email" required
                            autofocus />

                        @error('email')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="mb-6 relative">
                        <input id="password"
                            class="w-full px-4 py-3 pr-10 bg-gray-100 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('password') border-red-500 @enderror"
                            type="password" name="password" placeholder="Password" required />
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                            onclick="togglePassword('password')">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-600 text-white font-bold py-3 rounded-full hover:from-blue-700 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        SIGN IN
                    </button>

                    <!-- Mobile Sign Up Link -->
                    <div class="mt-6 text-center lg:hidden">
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                            Don't have an account? Register
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
        }
    </script>
</x-guest-layout>
