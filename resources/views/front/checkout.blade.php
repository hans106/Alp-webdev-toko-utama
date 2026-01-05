@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 md:px-12 py-12">
    
    <div class="mb-6">
        <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-primary transition font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            <span>Kembali ke Keranjang</span>
        </a>
    </div>

    <h1 class="text-3xl font-bold mb-8 text-slate-800">Checkout Pengiriman</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6">
            <strong class="font-bold">Waduh! Ada yang kurang nih:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="w-full lg:w-2/3">
            <form action="{{ route('checkout.process') }}" method="POST" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                @csrf
                
                <h3 class="text-xl font-bold mb-6 text-slate-800 border-b border-slate-100 pb-4">Data Penerima</h3>
                
                <div class="mb-6">
                    <label class="block font-bold text-slate-700 mb-2 text-sm">Nama Penerima</label>
                    <input type="text" value="{{ Auth::user()->name }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-slate-500 font-medium cursor-not-allowed" readonly>
                </div>

                <div class="mb-6">
                    <label class="block font-bold text-slate-700 mb-2 text-sm">Nomor WhatsApp / HP Aktif <span class="text-red-500">*</span></label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition" placeholder="Contoh: 081234567890" required>
                    <p id="phone-feedback" class="text-xs text-slate-400 mt-1">*Wajib angka, minimal 10 digit.</p>
                </div>

                <div class="mb-6">
                    <label class="block font-bold text-slate-700 mb-2 text-sm">Alamat Lengkap Pengiriman <span class="text-red-500">*</span></label>
                    <textarea id="address" name="address" rows="3" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition" placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan, Patokan..." required>{{ old('address') }}</textarea>
                    <p id="address-feedback" class="text-xs text-slate-400 mt-1">*Tulis alamat lengkap minimal 4 kata.</p>
                </div>

                <div class="mb-8">
                    <label class="block font-bold text-slate-700 mb-2 text-sm">Catatan (Opsional)</label>
                    <input type="text" name="notes" value="{{ old('notes') }}" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition" placeholder="Contoh: Pagar warna hitam">
                </div>

                <button id="submit-order" type="submit" disabled aria-disabled="true" class="w-full opacity-50 cursor-not-allowed bg-gradient-to-r from-primary to-indigo-600 text-white font-bold py-4 rounded-xl hover:shadow-lg transition transform hover:-translate-y-0.5 text-lg">
                    Buat Pesanan
                </button>
            </form>

            <script>
                // Real-time validation for phone and address
                const phoneInput = document.getElementById('phone');
                const addressInput = document.getElementById('address');
                const phoneFeedback = document.getElementById('phone-feedback');
                const addressFeedback = document.getElementById('address-feedback');
                const submitBtn = document.getElementById('submit-order');

                function validatePhone() {
                    const val = phoneInput.value.replace(/\D/g, ''); // keep digits only
                    const len = val.length;
                    const min = 10;
                    if (len >= min) {
                        phoneInput.classList.remove('border-slate-300');
                        phoneInput.classList.add('border-green-500');
                        phoneFeedback.textContent = 'Nomor cukup (' + len + ' digit)';
                        phoneFeedback.classList.remove('text-slate-400'); phoneFeedback.classList.add('text-green-600');
                        return true;
                    } else {
                        phoneInput.classList.remove('border-green-500');
                        phoneInput.classList.add('border-red-500');
                        const missing = min - len;
                        phoneFeedback.textContent = 'Kurang ' + missing + ' digit lagi';
                        phoneFeedback.classList.remove('text-green-600'); phoneFeedback.classList.add('text-red-600');
                        return false;
                    }
                }

                function validateAddress() {
                    const text = addressInput.value.trim();
                    const words = text ? text.split(/\s+/).length : 0;
                    const minWords = 4;
                    if (words >= minWords) {
                        addressInput.classList.remove('border-slate-300');
                        addressInput.classList.add('border-green-500');
                        addressFeedback.textContent = 'Alamat cukup (' + words + ' kata)';
                        addressFeedback.classList.remove('text-slate-400'); addressFeedback.classList.add('text-green-600');
                        return true;
                    } else {
                        addressInput.classList.remove('border-green-500');
                        addressInput.classList.add('border-red-500');
                        const missing = minWords - words;
                        addressFeedback.textContent = 'Kurang ' + missing + ' kata lagi';
                        addressFeedback.classList.remove('text-green-600'); addressFeedback.classList.add('text-red-600');
                        return false;
                    }
                }

                // Update submit button state based on validations
                function updateSubmitState() {
                    const okPhone = validatePhone();
                    const okAddress = validateAddress();
                    if (okPhone && okAddress) {
                        submitBtn.disabled = false;
                        submitBtn.removeAttribute('aria-disabled');
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        submitBtn.disabled = true;
                        submitBtn.setAttribute('aria-disabled', 'true');
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }

                phoneInput.addEventListener('input', updateSubmitState);
                addressInput.addEventListener('input', updateSubmitState);

                // Run initial validation on page load
                document.addEventListener('DOMContentLoaded', function() {
                    updateSubmitState();
                });

                // Handle submit reliably: normalize, validate, disable button and submit programmatically
                const checkoutForm = document.querySelector('form[action="{{ route('checkout.process') }}"]');
                checkoutForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Normalize phone to digits only so server validation counts digits correctly
                    phoneInput.value = phoneInput.value.replace(/\D/g, '');

                    const okPhone = validatePhone();
                    const okAddress = validateAddress();

                    if (!okPhone || !okAddress) {
                        alert('Perbaiki data pengiriman sebelum membuat pesanan.');
                        updateSubmitState();
                        return;
                    }

                    // Prevent double submit and show loading state
                    submitBtn.disabled = true;
                    submitBtn.setAttribute('aria-disabled', 'true');
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    const originalHtml = submitBtn.innerHTML;
                    submitBtn.innerHTML = 'Memproses...';

                    // Submit the form programmatically
                    checkoutForm.submit();

                    // (If submission fails or page doesn't navigate, revert after timeout to allow retry)
                    setTimeout(function() {
                        submitBtn.disabled = false;
                        submitBtn.removeAttribute('aria-disabled');
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        submitBtn.innerHTML = originalHtml;
                    }, 5000);
                });
            </script>
        </div>

        <div class="w-full lg:w-1/3">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 sticky top-24">
                <h3 class="text-xl font-bold mb-4">Ringkasan Barang</h3>
                
                <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2">
                    @foreach($carts as $cart)
                    <div class="flex gap-3 items-start border-b border-slate-50 pb-3 last:border-0">
                        @php
                        $imgSrc = null;
                        $imgPath = $cart->product->image_main ?? null;
                        // 1) Full URL
                        if ($imgPath && preg_match('/^https?:\/\//i', $imgPath)) {
                            $imgSrc = $imgPath;
                        }
                        // 2) Public path as-is (e.g., 'products/foo.jpg' saved in DB)
                        elseif ($imgPath && file_exists(public_path($imgPath))) {
                            $imgSrc = asset($imgPath);
                        }
                        // 3) Public products folder
                        elseif ($imgPath && file_exists(public_path('products/' . $imgPath))) {
                            $imgSrc = asset('products/' . $imgPath);
                        }
                        // 4) fallback
                        else {
                            $imgSrc = asset('logo/logo_utama.jpeg');
                        }
                    @endphp
                    <div class="w-12 h-12 bg-slate-50 rounded-lg overflow-hidden flex-shrink-0 border border-slate-200">
                        <img src="{{ $imgSrc }}" class="w-full h-full object-contain" onerror="this.onerror=null; this.src='{{ asset('logo/logo_utama.jpeg') }}';">
                    </div>
                        <div class="flex-grow text-sm">
                            <p class="font-bold text-slate-700 line-clamp-1">{{ $cart->product->name }}</p>
                            <div class="flex justify-between mt-1 text-slate-500">
                                <span>{{ $cart->qty }} x Rp {{ number_format($cart->product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-slate-200 pt-4 flex justify-between items-center">
                    <span class="font-bold text-slate-600">Total Harga</span>
                    <span class="text-2xl font-extrabold text-primary">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection