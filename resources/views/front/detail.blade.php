@extends('layouts.main')

@section('content')
    <div class="max-w-6xl mx-auto px-4 md:px-8 py-10">

        {{-- ALERT SUCCESS/ERROR --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 2 2 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- DETAIL PRODUK WRAPPER --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-[#F7E7CE] overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">

                {{-- KOLOM KIRI: GAMBAR UTAMA --}}
                <div class="bg-[#FFFAF7] p-8 md:p-12 flex flex-col justify-center items-center border-b md:border-b-0 md:border-r border-[#F7E7CE] relative">
                    
                    {{-- PERBAIKAN 1: Pakai image_main --}}
                    <img src="{{ asset($product->image_main) }}" alt="{{ $product->name }}"
                        class="w-full h-auto object-contain max-h-[400px] drop-shadow-lg transform hover:scale-105 transition duration-500">

                    {{-- PERBAIKAN 2: Kode Galeri (productImages) SAYA HAPUS total biar gak error --}}

                    @auth
                        <button id="favorite-btn" data-product-id="{{ $product->id }}" class="absolute top-4 right-4 p-2 rounded-full bg-white shadow hover:scale-105 transition">
                            @if(isset($isFavorited) && $isFavorited)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4 4 0 015.656 0L12 8.343l2.026-2.025a4 4 0 115.656 5.656L12 20.657l-7.682-7.683a4 4 0 010-5.656z" />
                                </svg>
                            @endif
+                        </button>
+                    @endauth
                
                </div>

                {{-- KOLOM KANAN: INFO PRODUK --}}
                <div class="p-8 md:p-12 flex flex-col">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="bg-[#FFF3EE] text-[#8B0000] text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider border border-[#E6B2A6]">
                            {{ $product->category->name }}
                        </span>
                        <span class="text-slate-500 text-sm font-medium">Brand: {{ $product->brand->name ?? 'Umum' }}</span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <div class="text-4xl font-extrabold text-[#8B0000] mb-8 tracking-tight">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    <div class="prose prose-slate text-slate-600 mb-8 flex-grow leading-relaxed">
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Description:</h3>
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="mt-auto pt-8 border-t border-[#F7E7CE]">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-sm font-bold text-slate-700">Stok Tersisa</span>
                            @if ($product->stock > 5)
                                <span class="text-emerald-600 font-bold bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">
                                    {{ $product->stock }} pcs
                                </span>
                            @else
                                <span class="text-rose-600 font-bold bg-rose-50 px-3 py-1 rounded-lg border border-rose-100 animate-pulse">
                                    {{ $product->stock }} pcs (Segera Habis!)
                                </span>
                            @endif
                        </div>

                        {{-- TOMBOL BELI / LOGIN / EDIT --}}
                        @auth
                            @if (Auth::user()->role === 'customer')
                                @php
                                    $cartItem = \App\Models\Cart::where('user_id', Auth::id())
                                                                ->where('product_id', $product->id)
                                                                ->first();
                                @endphp
                                
                                @if($cartItem)
                                    {{-- Jika sudah ada di cart, tampilkan +/- buttons --}}
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-center gap-4 bg-slate-100 rounded-xl p-4 border border-slate-200">
                                            <form action="{{ route('cart.update', $cartItem->id) }}" method="POST" class="cart-update-form">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="type" value="minus">
                                                <button type="submit"
                                                    class="w-10 h-10 rounded-full bg-white hover:bg-rose-500 hover:text-white flex items-center justify-center font-bold text-slate-700 shadow-sm transition"
                                                    title="Kurangi jumlah">
                                                    −
                                                </button>
                                            </form>
                                            <span class="font-bold text-lg text-slate-800 w-12 text-center" id="qty-display">{{ $cartItem->qty }}</span>
                                            <form action="{{ route('cart.update', $cartItem->id) }}" method="POST" class="cart-update-form">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="type" value="plus">
                                                <button type="submit"
                                                    class="w-10 h-10 rounded-full bg-white hover:bg-emerald-500 hover:text-white flex items-center justify-center font-bold text-slate-700 shadow-sm transition"
                                                    title="Tambah jumlah">
                                                    +
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST" class="cart-remove-form">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="w-full bg-slate-300 text-slate-700 font-bold py-3 px-6 rounded-xl 
                                                       hover:bg-slate-400
                                                       transition text-lg"
                                                onclick="return confirm('Hapus dari keranjang?')">
                                                Hapus dari Keranjang
                                            </button>
                                        </form>
                                        
                                        <p class="text-xs text-center text-slate-500 mt-2">
                                            Produk sudah dalam keranjang. Ubah jumlah sesuai kebutuhan.
                                        </p>
                                    </div>
                                @else
                                    {{-- Jika belum ada di cart, tampilkan tombol add --}}
                                    <form action="{{ route('cart.store', $product->id) }}" method="POST" class="cart-add-form">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-[#6B0F1A] text-white font-bold py-4 px-6 rounded-xl 
                                                   border border-[#7A1620]
                                                   hover:bg-[#7D1521] hover:border-[#D4AF37] 
                                                   hover:shadow-[0_0_10px_rgba(212,175,55,0.25)]
                                                   transition transform hover:-translate-y-0.5 
                                                   flex justify-center items-center gap-3 text-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Masukkan Keranjang
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="block w-full bg-[#FDBA31] text-[#8B0000] text-center font-bold py-4 px-6 rounded-xl hover:bg-[#f8b122] transition shadow-lg">
                                    Edit Produk (Mode Admin)
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="block w-full bg-slate-800 text-white text-center font-bold py-4 px-6 rounded-xl hover:bg-slate-900 transition shadow-lg">
                                Login untuk Membeli
                            </a>
                        @endauth

                    </div>
                </div>
            </div>
        </div>

        {{-- REVIEW SECTION --}}
        <div class="mt-8 bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <h2 class="text-2xl font-bold mb-4">Ulasan Pelanggan</h2>

            @php $avgRounded = round($avgRating); @endphp
            <div class="flex items-center gap-4 mb-4">
                <div class="flex items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $avgRounded)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endif
                    @endfor
                </div>
                <div class="text-sm text-slate-600">Rata-rata dari {{ $reviews->count() }} ulasan</div>
            </div>

            @auth
                <form id="review-form" action="{{ route('product.review.store', $product->id) }}" method="POST" class="mb-6">
                    @csrf
                    <div class="flex items-center gap-3 mb-3">
                        <label class="font-bold">Rating:</label>
                        <select name="rating" id="rating" class="border rounded px-3 py-2">
                            <option value="5">5 - Sangat Baik</option>
                            <option value="4">4 - Baik</option>
                            <option value="3">3 - Cukup</option>
                            <option value="2">2 - Kurang</option>
                            <option value="1">1 - Buruk</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <textarea name="comment" id="comment" rows="4" class="w-full border rounded p-3" placeholder="Tulis ulasan Anda"></textarea>
                    </div>
                    <button type="submit" class="bg-rose-600 text-white px-4 py-2 rounded font-bold">Kirim Ulasan</button>
                </form>
            @else
                <p class="mb-4">Silakan <a href="{{ route('login') }}" class="text-rose-600 font-bold">login</a> untuk menulis ulasan.</p>
            @endauth

            <div id="reviews-list" class="space-y-4">
                @forelse ($reviews as $rev)
                    <div class="border rounded p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-bold">{{ $rev->user->name ?? 'Pengguna' }}</div>
                            <div class="flex items-center gap-1">
                                @for ($s = 1; $s <= 5; $s++)
                                    @if ($s <= $rev->rating)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="text-slate-700">{{ $rev->comment }}</div>
                        <div class="text-xs text-slate-400 mt-2">{{ $rev->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="text-slate-500">Belum ada ulasan untuk produk ini.</div>
                @endforelse
            </div>
        </div>

        {{-- PRODUK SEJENIS --}}
        @if (isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-8 text-slate-800">Produk Sejenis</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $related)
                        <div class="bg-white rounded-xl border border-[#F7E7CE] p-4 hover:shadow-md transition group h-full flex flex-col">
                            <a href="{{ route('front.product', $related->slug) }}" class="block relative h-40 bg-[#FFFAF7] rounded-lg mb-3 overflow-hidden">
                                
                                {{-- PERBAIKAN 3: Pakai image_main juga disini --}}
                                <img src="{{ asset($related->image_main) }}"
                                    class="w-full h-full object-contain p-4 group-hover:scale-110 transition duration-300">
                            </a>
                            
                            <div class="flex flex-col flex-1">
                                <h4 class="font-bold text-slate-800 line-clamp-2 text-sm mb-2 group-hover:text-[#8B0000] transition">
                                    {{ $related->name }}
                                </h4>
                                <div class="mt-auto text-[#8B0000] font-bold">
                                    Rp {{ number_format($related->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        // AJAX Form Submission untuk Cart Operations (stay on page)
        document.addEventListener('DOMContentLoaded', function() {
            // Handle Add to Cart
            const addToCartForm = document.querySelector('.cart-add-form');
            if (addToCartForm) {
                addToCartForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: new FormData(this)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload halaman untuk show updated cart buttons
                            location.reload();
                        } else {
                            alert(data.error || 'Gagal menambah ke keranjang');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Coba lagi.');
                    });
                });
            }

            // Handle Update Cart Quantity
            const updateForms = document.querySelectorAll('.cart-update-form');
            updateForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: new FormData(this)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update qty display
                            const qtyDisplay = document.querySelector('#qty-display');
                            if (qtyDisplay) {
                                qtyDisplay.textContent = data.newQty;
                            }
                            // If qty becomes 0, reload the page to show "Masukkan Keranjang" button
                            if (data.newQty === 0) {
                                setTimeout(() => location.reload(), 500);
                            }
                        } else {
                            alert(data.error || 'Gagal update kuantitas');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Coba lagi.');
                    });
                });
            });

            // Handle Remove from Cart
            const removeForm = document.querySelector('.cart-remove-form');
            if (removeForm) {
                removeForm.addEventListener('submit', function(e) {
                    if (!confirm('Hapus dari keranjang?')) {
                        e.preventDefault();
                        return;
                    }
                    
                    e.preventDefault();
                    
                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: new FormData(this)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload untuk show tombol "Masukkan Keranjang" lagi
                            location.reload();
                        } else {
                            alert('Gagal hapus dari keranjang');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Coba lagi.');
                    });
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const favBtn = document.getElementById('favorite-btn');
            if (favBtn) {
                favBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    fetch(`/produk/${productId}/favorite`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            // simple: reload to reflect new favorite state
                            location.reload();
                        } else if (data.error) {
                            alert(data.error);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Gagal update favorit');
                    });
                });
            }

            const reviewForm = document.getElementById('review-form');
            if (reviewForm) {
                reviewForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const action = this.action;
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const formData = new FormData(this);

                    fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            // reload to update reviews and average
                            location.reload();
                        } else if (data.error) {
                            alert(data.error);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Gagal mengirim ulasan');
                    });
                });
            }
        });
    </script>
@endsection