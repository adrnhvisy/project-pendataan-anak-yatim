<x-app-layout>
    <div class="py-12 bg-[#f8f9ff]">
        <div class="max-w-xl mx-auto bg-white p-6 rounded-xl border border-[#e5eeff]">
            <h2 class="text-lg font-bold mb-4">Edit Kategori</h2>
            
            <form action="{{ route('kategori-dokumen.update', $kategoriDokumen->id) }}" method="POST" id="form-edit-kategori">
                @method('PUT')
                @include('pages.kategori-dokumen.form', ['kategoriDokumen' => $kategoriDokumen])
                
                <button type="submit" id="btn-submit" class="bg-[#004ac6] text-white px-4 py-2 rounded-lg mt-4 flex items-center justify-center transition-all duration-200">
                    <svg id="spinner-submit" class="hidden w-4 h-4 mr-2 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="text-submit" class="font-medium">Perbarui</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('form-edit-kategori');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    const btn = document.getElementById('btn-submit');
                    const spinner = document.getElementById('spinner-submit');
                    const text = document.getElementById('text-submit');

                    // Mencegah double submit jika tombol sudah dalam state loading
                    if (btn.disabled) {
                        e.preventDefault();
                        return;
                    }

                    // 1. Kunci tombol dan perbarui gaya visual (UX)
                    btn.disabled = true;
                    btn.classList.add('opacity-70', 'cursor-not-allowed');
                    
                    // 2. Tambahkan standar Aksesibilitas (A11y)
                    btn.setAttribute('aria-disabled', 'true');
                    btn.setAttribute('aria-busy', 'true');

                    // 3. Tampilkan Spinner dan ubah teks
                    spinner.classList.remove('hidden');
                    text.textContent = 'Memperbarui...';

                    // Form akan otomatis terkirim secara native oleh browser setelah ini
                });
            }
        });
    </script>
</x-app-layout>