@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 md:px-12 py-12">

        {{-- Title --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#1A0C0C] tracking-tight mb-2">
                Product
            </h1>
            <p class="text-[#6b4a4a]">Temukan produk terbaik dengan harga tetangga.</p>
        </div>

        <div class="!bg-white p-6 rounded-2xl shadow-lg shadow-[#A4102520] border border-[#E8D6D0] mb-10">
            <form action="{{ url()->current() }}" method="GET" class="flex flex-col lg:flex-row gap-4 items-center">

                {{-- Search Bar --}}
                <div class="w-full lg:w-1/3 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-4 top-3.5 !text-[#B79B98]"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                        class="w-full !bg-white border border-[#E8D6D0] rounded-xl
                pl-12 pr-4 py-3 focus:ring-2 focus:ring-[#A41025] 
                !text-gray-900 placeholder-[#B79B98] outline-none font-medium">
                </div>

                {{-- Category --}}
                <div class="w-full lg:w-1/4">
                    <select name="category" onchange="this.form.submit()"
                        class="w-full !bg-white border border-[#E8D6D0] rounded-xl px-4 py-3
                focus:ring-2 focus:ring-[#A41025] outline-none cursor-pointer
                !text-gray-900 appearance-none font-medium">
                        <option value="">All Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Brand --}}
                <div class="w-full lg:w-1/4">
                    <select name="brand" onchange="this.form.submit()"
                        class="w-full !bg-white border border-[#E8D6D0] rounded-xl px-4 py-3
                focus:ring-2 focus:ring-[#A41025] outline-none cursor-pointer
                !text-gray-900 appearance-none font-medium">
                        <option value="">All Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->slug }}" {{ request('brand') == $brand->slug ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Max Price --}}
                <div class="w-full lg:w-1/4 relative">
                    <span class="absolute left-4 top-3.5 text-[#7c5b58] font-bold text-sm">Rp</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Maximum Price"
                        class="w-full !bg-white border border-[#E8D6D0] rounded-xl 
                pl-10 pr-4 py-3 focus:ring-2 focus:ring-[#A41025] 
                outline-none !text-gray-900 placeholder-[#B79B98]"
                        min="0">
                </div>

                {{-- Search Button --}}
                <button type="submit"
                    class="w-full lg:w-auto bg-[#A41025] hover:bg-[#820c1d]
                    text-white font-bold px-8 py-3 rounded-xl hover:shadow-lg
                    transition transform hover:-translate-y-0.5">
                    Search
                </button>
            </form>
        </div>



        {{-- Product List --}}
        @if ($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                @foreach ($products as $item)
                    <div
                        class="bg-white rounded-2xl border border-[#E8D6D0] shadow-sm
                    hover:shadow-xl transition duration-300 group flex flex-col h-full overflow-hidden">

                        {{-- Image --}}
                        <a href="{{ route('front.product', $item->slug) }}"
                            class="block relative h-48 md:h-56 bg-[#F8F5F3] overflow-hidden">
                            <img src="{{ asset($item->image_main) }}" alt="{{ $item->name }}"
                                class="w-full h-full object-contain p-6 group-hover:scale-110 transition duration-500">

                            @if ($item->stock <= 5)
                                <span
                                    class="absolute top-3 right-12 bg-[#A41025] text-white text-[10px] 
                                font-bold px-2 py-1 rounded-full shadow-sm">
                                    Sisa {{ $item->stock }}
                                </span>
                            @endif

                            {{-- Favorite (floating right) using preloaded user favorites --}}
                            @php
                                $isFavorited = $userFavorites->has($item->id);
                            @endphp

                            <button type="button"
                                class="catalog-favorite-btn absolute top-3 right-3 bg-white/90 p-2 rounded-full shadow-sm hover:scale-105 transition z-20"
                                data-product-id="{{ $item->id }}" aria-pressed="{{ $isFavorited ? 'true' : 'false' }}"
                                title="Favorit">
                                @if ($isFavorited)
                                    <!-- filled heart -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#A41025]"
                                        viewBox="0 0 20 20" fill="#A41025">
                                        <path
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.828l-6.828-6.828a4 4 0 010-5.656z" />
                                    </svg>
                                @else
                                    <!-- outline heart -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#A41025]"
                                        viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.828l-6.828-6.828a4 4 0 010-5.656z" />
                                    </svg>
                                @endif
                            </button>
                        </a>

                        <div class="p-5 flex flex-col flex-1 row">
                            {{-- Category --}}
                            <div class="mb-2">
                                <span
                                    class="text-[10px] font-bold text-[#A41025] uppercase tracking-wider
                                bg-[#F8E7E8] px-2 py-1 rounded-md">
                                    {{ $item->category->name }}
                                </span>
                            </div>

                            {{-- Product Name --}}
                            <a href="{{ route('front.product', $item->slug) }}"
                                class="text-base font-bold text-[#1A0C0C] hover:text-[#A41025]
                            transition line-clamp-2 mb-2 leading-snug">
                                {{ $item->name }}
                            </a>

                            {{-- Price & Cart --}}
                            <div class="mt-auto pt-3 border-t border-[#F1E2DD] flex justify-between items-center">
                                <div class="text-base md:text-lg font-extrabold text-[#1A0C0C]">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </div>

                                <form action="{{ route('cart.store', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-[#F8F5F3] text-[#7c5b58] p-2 rounded-lg
                                    hover:bg-[#A41025] hover:text-white transition shadow-sm"
                                        title="Masukkan Keranjang">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-[#F8F5F3] rounded-3xl border border-dashed border-[#E8D6D0]">
                <p class="text-[#7c5b58]">Produk tidak ditemukan.</p>
                <a href="{{ route('catalog') }}" class="text-[#A41025] font-bold mt-2 inline-block hover:underline">Reset
                    Filter</a>
            </div>
        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle Add to Cart button clicks
            const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');

            addToCartBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    addToCart(productId);
                });
            });

            function addToCart(productId) {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                fetch(`/cart/add/${productId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Find the cart actions container and replace button with quantity selector
                            const container = document.querySelector(`.cart-actions-${productId}`);
                            if (container) {
                                const stock = parseInt(container.dataset.stock);
                                const currentQty = data.cart.qty || 1;

                                container.innerHTML = `
                                <div class="flex items-center gap-2 bg-[#F8F5F3] rounded-lg px-2 py-1.5 border border-[#E8D6D0]">
                                    <button type="button" 
                                        class="qty-minus-btn w-6 h-6 rounded-md bg-white hover:bg-[#E8D6D0] 
                                        flex items-center justify-center font-bold text-[#7c5b58] shadow-sm transition text-sm"
                                        data-product-id="${productId}"
                                        data-cart-id="${data.cart.id}">
                                        -
                                    </button>
                                    <span class="qty-display font-bold w-6 text-center text-[#1A0C0C] text-sm">
                                        ${currentQty}
                                    </span>
                                    <button type="button" 
                                        class="qty-plus-btn w-6 h-6 rounded-md bg-white hover:bg-[#E8D6D0] 
                                        flex items-center justify-center font-bold text-[#7c5b58] shadow-sm transition text-sm"
                                        data-product-id="${productId}"
                                        data-cart-id="${data.cart.id}"
                                        data-stock="${stock}"
                                        data-current-qty="${currentQty}">
                                        +
                                    </button>
                                </div>
                            `;

                                // Add event listeners to new buttons
                                attachQuantityListeners(productId);
                            }
                        } else if (data.error) {
                            alert(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menambahkan ke keranjang');
                    });
            }

            function attachQuantityListeners(productId) {
                const container = document.querySelector(`.cart-actions-${productId}`);
                const minusBtn = container.querySelector('.qty-minus-btn');
                const plusBtn = container.querySelector('.qty-plus-btn');

                minusBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    updateQuantity(productId, 'minus', this);
                });

                plusBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    updateQuantity(productId, 'plus', this);
                });
            }

            function updateQuantity(productId, type, button) {
                const cartId = button.dataset.cartId;
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const container = document.querySelector(`.cart-actions-${productId}`);
                const stock = parseInt(container.dataset.stock);
                const qtyDisplay = container.querySelector('.qty-display');
                const currentQty = parseInt(qtyDisplay.textContent);

                // Check stock limit before sending request for plus
                if (type === 'plus' && currentQty >= stock) {
                    alert('Stok tidak cukup!');
                    return;
                }

                fetch(`/cart/update/${cartId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            type: type
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update quantity display
                            const newQty = data.newQty !== undefined ? data.newQty : currentQty;

                            if (newQty < 1) {
                                // If qty becomes 0, reset to add to cart button
                                container.innerHTML = `
                                <button type="button" 
                                    class="add-to-cart-btn bg-[#F8F5F3] text-[#7c5b58] p-2 rounded-lg
                                    hover:bg-[#A41025] hover:text-white transition shadow-sm"
                                    data-product-id="${productId}"
                                    title="Masukkan Keranjang">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </button>
                            `;

                                // Re-attach event listener for add to cart button
                                const newBtn = container.querySelector('.add-to-cart-btn');
                                newBtn.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    addToCart(productId);
                                });
                            } else {
                                qtyDisplay.textContent = newQty;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal mengupdate keranjang');
                    });
            }


        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const favBtns = document.querySelectorAll('.catalog-favorite-btn');
            if (favBtns.length) {
                favBtns.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const productId = this.dataset.productId;
                        const token = document.querySelector('meta[name="csrf-token"]')
                            ?.getAttribute('content');

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
                                    // reload to reflect new favorite state (same logic as detail view)
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
                });
            }
        });
    </script>
@endsection
