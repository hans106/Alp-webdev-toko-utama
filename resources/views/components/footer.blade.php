<footer class="bg-[#2B0A0A] text-[#FDECEC] py-10 border-t border-[#3B0F0F] mt-auto">
    <div class="container mx-auto px-6 lg:px-12">

        {{-- Layout Utama: Flex Row untuk Desktop (Kiri-Kanan), Flex Col untuk HP (Atas-Bawah) --}}
        <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-8 mb-8">

            {{-- BAGIAN KIRI: Identitas Toko (Rata Kiri di Desktop, Tengah di HP) --}}
            <div class="w-full md:w-1/2 text-center md:text-left">
                <a href="{{ route('home') }}" class="text-2xl font-extrabold text-[#E8B04C] mb-4 inline-block">
                    Toko<span class="text-white">Utama</span>
                </a>
                <p class="text-[#D6B4B4] text-sm leading-relaxed mb-4 max-w-md mx-auto md:mx-0">
                    Mitra terpercaya kebutuhan harian keluarga Anda sejak 1959. Harga tetangga, kualitas juara.
                </p>
                <div class="text-sm space-y-1 text-[#FDECEC]">
                    <p>Karanganyar, Jawa Tengah</p>
                    <p>Buka: 08.00 - 17.00 WIB</p>
                </div>
            </div>

            {{-- BAGIAN KANAN: Kontak (Rata Kanan di Desktop, Tengah di HP) --}}
            <div class="w-full md:w-1/2 text-center md:text-right mt-6 md:mt-0">
                <h3 class="text-white font-bold text-lg mb-3">Butuh Bantuan?</h3>
                <p class="text-sm text-[#D6B4B4] mb-4">Hubungi Admin Keluarga kami langsung via WhatsApp.</p>

                {{-- Wrapper Tombol: Mengatur posisi tombol --}}
                <div class="flex flex-col items-center md:items-end">
                    <button onclick="openWaModal()" 
                        class="inline-flex justify-center items-center gap-2 bg-green-600 hover:bg-green-500 text-white px-6 py-3 rounded-xl transition font-bold shadow-lg shadow-green-900/20 hover:-translate-y-1 transform duration-200 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        Chat WhatsApp
                    </button>
                </div>
            </div>
        </div>

        <div class="border-t border-[#3B0F0F] pt-8 text-center text-sm text-[#D6B4B4]">
            &copy; {{ date('Y') }} Toko Utama Karanganyar. All rights reserved.
        </div>
    </div>

    {{-- MODAL WHATSAPP (ISI TETAP SAMA) --}}
    <div id="waModalFooter" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity opacity-0" id="waBackdrop" onclick="closeWaModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:w-full sm:max-w-sm opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" id="waPanel">
                    
                    <div class="bg-green-600 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-white font-bold text-lg flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            Hubungi Admin
                        </h3>
                        <button onclick="closeWaModal()" class="text-white hover:text-green-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-3">
                        <p class="text-slate-600 mb-2">Silakan pilih admin yang ingin dihubungi:</p>
                        
                        <a href="https://wa.me/6285702328000?text=Ivan%20Purnomo%20Liem%20Owner" target="_blank"
                           class="flex items-center gap-4 p-4 border border-slate-200 rounded-xl hover:bg-green-50 hover:border-green-300 transition group">
                            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold text-lg">P</div>
                            <div><h4 class="font-bold text-slate-800">Ivan Purnomo Liem</h4><p class="text-xs text-slate-500">Owner</p></div>
                        </a>
                        <a href="https://wa.me/6283865802000?text=Kristiani%20PudjiAstuti%20Keuangan%20Management" target="_blank"
                           class="flex items-center gap-4 p-4 border border-slate-200 rounded-xl hover:bg-green-50 hover:border-green-300 transition group">
                            <div class="w-10 h-10 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center font-bold text-lg">M</div>
                            <div><h4 class="font-bold text-slate-800">Kristiani PudjiAstuti</h4><p class="text-xs text-slate-500">Keuangan</p></div>
                        </a>
                        <a href="https://wa.me/6283146018000?text=Hans%20Vere%20Liem%20Support" target="_blank"
                           class="flex items-center gap-4 p-4 border border-slate-200 rounded-xl hover:bg-green-50 hover:border-green-300 transition group">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-lg">A</div>
                            <div><h4 class="font-bold text-slate-800">Hans Vere Liem</h4><p class="text-xs text-slate-500">Support</p></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    function openWaModal() {
        const modal = document.getElementById('waModalFooter');
        const backdrop = document.getElementById('waBackdrop');
        const panel = document.getElementById('waPanel');
        modal.classList.remove('hidden');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
        }, 50);
    }
    function closeWaModal() {
        const modal = document.getElementById('waModalFooter');
        const backdrop = document.getElementById('waBackdrop');
        const panel = document.getElementById('waPanel');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
        panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
        setTimeout(() => { modal.classList.add('hidden'); }, 300);
    }
</script>