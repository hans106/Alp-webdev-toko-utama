@extends('layouts.auth')

@section('content')
    <div class="flex justify-center items-center min-h-[100vh]">
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg border">
            <h2 class="text-2xl font-bold text-center mb-6">Masuk Toko Utama</h2>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-8">
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="loginPass"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition pr-10"
                            placeholder="Masukkan password" required>

                        <button type="button" onclick="togglePassword('loginPass', this)"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-slash hidden" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700">Login</button>
            </form>
            <p class="text-center mt-4 text-sm">Belum punya akun? <a href="{{ route('register') }}"
                    class="text-blue-600 font-bold">Daftar disini</a></p>
        </div>
    </div>
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const iconEye = btn.querySelector('.eye-open');
            const iconSlash = btn.querySelector('.eye-slash');

            if (input.type === "password") {
                input.type = "text";
                iconEye.classList.add('hidden');
                iconSlash.classList.remove('hidden');
            } else {
                input.type = "password";
                iconEye.classList.remove('hidden');
                iconSlash.classList.add('hidden');
            }
        }
    </script>
@endsection
