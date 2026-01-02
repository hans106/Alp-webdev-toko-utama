{{-- FOOTER SECTION COMPACT --}}
<footer class="bg-[#2B0A0A] text-[#FDECEC] py-8 md:py-10 border-t-[4px] border-[#E1B56A] mt-auto relative overflow-hidden">
    
    {{-- Pattern Background Tipis --}}
    <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(#E1B56A 1px, transparent 1px); background-size: 20px 20px;"></div>

    <div class="container mx-auto px-6 lg:px-12 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

            {{-- BAGIAN KIRI: Info Toko (Lebih Ramping) --}}
            <div class="text-center md:text-left">
                <a href="{{ route('home') }}" class="inline-block group mb-3">
                    <h2 class="text-3xl font-extrabold font-serif tracking-tight text-[#E1B56A]">
                        Toko<span class="text-white group-hover:text-[#F6E3C1] transition-colors">Utama</span>
                    </h2>
                    <span class="text-[10px] tracking-[0.2em] uppercase text-[#D6B4B4] block">Karanganyar</span>
                </a>
                
                {{-- Alamat & Jam Buka (Tampilan Compact tanpa Box Besar) --}}
                <div class="space-y-2 text-sm text-[#D6B4B4] mt-2">
                    <div class="flex items-center justify-center md:justify-start gap-2">
                        <svg class="w-4 h-4 text-[#E1B56A] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Jl Yudomo SHD No 1. Karanganyar</span>
                    </div>
                    <div class="flex items-center justify-center md:justify-start gap-2">
                        <svg class="w-4 h-4 text-[#E1B56A] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Buka Setiap Hari: 08.00 - 16.30 WIB</span>
                    </div>
                </div>
            </div>

            {{-- BAGIAN KANAN: Call to Action (Button Lebih Proporsional) --}}
            <div class="text-center md:text-right flex flex-col items-center md:items-end">
                <h1 class="text-2xl font-extrabold mb-3">Hubungi Kami</h1>
                <p class="text-[#D6B4B4] text-xs md:text-sm mb-3 italic">"Kualitas Juara, Harga Tetangga"</p>
                
                <button onclick="openWaModal()" 
                    class="group relative inline-flex items-center justify-center gap-2
                   bg-[#25D366] text-white overflow-hidden
                   font-bold py-2.5 px-6 md:py-3 md:px-8 rounded-full text-sm md:text-base
                   shadow-lg shadow-[#25D366]/20
                   hover:bg-[#1ebc57] hover:-translate-y-0.5
                   transition-all duration-300 border border-[#25D366]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    Whatsapp
                </button>
            </div>
        </div>

        {{-- Copyright Line --}}
        <div class="border-t border-[#E1B56A]/20 pt-4 mt-6 text-center">
            <p class="text-[10px] md:text-xs text-[#D6B4B4]/60">
                &copy; {{ date('Y') }} Toko Utama Karanganyar. All rights reserved.
            </p>
        </div>
    </div>
</footer>

{{-- MODAL WHATSAPP (Sama seperti sebelumnya, style tetap premium) --}}
<div id="waModalFooter" class="fixed inset-0 z-[9999] hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-[#2B0A0A]/80 backdrop-blur-sm transition-opacity opacity-0" id="waBackdrop" onclick="closeWaModal()"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-[2rem] bg-white text-left shadow-2xl transition-all w-full max-w-sm opacity-0 translate-y-10 sm:scale-95 border border-[#E1B56A]/20" id="waPanel">
                
                {{-- Header Modal --}}
                <div class="bg-gradient-to-r from-[#128C7E] to-[#075E54] px-5 py-4 flex justify-between items-center relative overflow-hidden">
                    <h3 class="text-white font-bold text-base flex items-center gap-2 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        Hubungi Kami
                    </h3>
                    <button onclick="closeWaModal()" class="text-white hover:bg-white/20 rounded-full p-1"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>

                {{-- List Admin (Scrollable jika layar pendek) --}}
                <div class="p-4 space-y-3 bg-[#F9F9F9] max-h-[60vh] overflow-y-auto">
                    {{-- Admin 1 --}}
                    <a href="https://wa.me/6285702328000?text=Halo%20Pak%20Ivan,%20saya%20mau%20tanya%20produk..." target="_blank"
                       class="flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-xl hover:border-[#25D366] hover:shadow-md transition-all">
                        <div class="w-10 h-10 bg-[#25D366] text-white rounded-full flex items-center justify-center font-bold">P</div>
                        <div><h4 class="font-bold text-sm text-slate-800">Ivan Purnomo Liem</h4><span class="text-[10px] bg-green-100 text-green-700 px-1.5 py-0.5 rounded">Owner</span></div>
                    </a>
                    {{-- Admin 2 --}}
                    <a href="https://wa.me/6283865802000?text=Halo%20Bu%20Kristiani,%20terkait%20keuangan..." target="_blank"
                       class="flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-xl hover:border-[#800000] hover:shadow-md transition-all">
                        <div class="w-10 h-10 bg-[#800000] text-white rounded-full flex items-center justify-center font-bold">M</div>
                        <div><h4 class="font-bold text-sm text-slate-800">Kristiani P.</h4><span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.5 rounded">Keuangan</span></div>
                    </a>
                    {{-- Admin 3 --}}
                    <a href="https://wa.me/6283146018000?text=Halo%20Hans,%20bisa%20bantu%20saya..." target="_blank"
                       class="flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-xl hover:border-blue-600 hover:shadow-md transition-all">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">A</div>
                        <div><h4 class="font-bold text-sm text-slate-800">Hans Vere Liem</h4><span class="text-[10px] bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded">Support</span></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openWaModal() {
        const m = document.getElementById('waModalFooter'), b = document.getElementById('waBackdrop'), p = document.getElementById('waPanel');
        m.classList.remove('hidden'); void m.offsetWidth;
        b.classList.remove('opacity-0'); p.classList.remove('opacity-0', 'translate-y-10', 'sm:scale-95'); p.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
    }
    function closeWaModal() {
        const m = document.getElementById('waModalFooter'), b = document.getElementById('waBackdrop'), p = document.getElementById('waPanel');
        b.classList.add('opacity-0'); p.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100'); p.classList.add('opacity-0', 'translate-y-10', 'sm:scale-95');
        setTimeout(() => m.classList.add('hidden'), 300);
    }
</script>