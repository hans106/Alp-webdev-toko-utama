@extends('layouts.auth')

@section('content')
<div class="flex justify-center items-center min-h-[100vh]">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg border">
        <h2 class="text-2xl font-bold text-center mb-6">Daftar Akun Baru</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                <ul>@foreach ($errors->all() as $error) <li>• {{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 rounded hover:bg-green-700">Daftar</button>
        </form>
        <p class="text-center mt-4 text-sm">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold">Login disini</a></p>
    </div>
</div>
@endsection