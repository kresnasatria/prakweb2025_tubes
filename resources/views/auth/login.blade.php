<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Login Toko</h2>
        <p class="text-gray-600">Masuk untuk mulai berbelanja</p>
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                   type="email" name="email" value="{{ old('email') }}" required autofocus />
            
            @error('email')
                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
            <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                   type="password" name="password" required />
            
            @error('password')
                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('register') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4">
                Belum punya akun?
            </a>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 ml-3">
                Log in
            </button>
        </div>
    </form>
</x-guest-layout>