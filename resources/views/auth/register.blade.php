<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Akun Baru</h2>
    </div>

    <form method="POST" action="#">
        @csrf

        <div>
            <label for="name" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
            <input id="name" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                   type="text" name="name" required autofocus />
        </div>

        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                   type="email" name="email" required />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
            <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                   type="password" name="password" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <button type="button" onclick="alert('Fitur Register belum diaktifkan di Controller')" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 ml-4">
                Register
            </button>
        </div>
    </form>
</x-guest-layout>