<x-app-layout>
    <div class="py-12 bg-[#f8f9ff]">
        <div class="max-w-xl mx-auto bg-white p-6 rounded-xl border border-[#e5eeff]">
            <h2 class="text-lg font-bold mb-4">Tambah Kategori</h2>

            <form action="{{ route('kategori-dokumen.store') }}" method="POST" id="form-kategori">
                @include('pages.kategori-dokumen.form')

                <a href="{{ route('kategori-dokumen.index') }}"
                    class="bg-[#FFFFFF] border border-gray-300 text-gray px-4 py-2 rounded-lg mt-4 inline-flex items-center justify-center transition-all duration-200">Batal</a>

                <button type="submit" id="btn-submit"
                    class="bg-[#004ac6] text-white px-4 py-2 rounded-lg mt-4 inline-flex items-center justify-center transition-all duration-200">

                    <svg id="btn-spinner" class="hidden animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>

                    <span id="btn-text">Simpan</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('form-kategori');
            const btn = document.getElementById('btn-submit');
            const spinner = document.getElementById('btn-spinner');
            const text = document.getElementById('btn-text');

            if (form) {
                form.addEventListener('submit', function (e) {
                    // Mencegah klik ganda jika tombol sudah dalam status disabled
                    if (btn.disabled) {
                        e.preventDefault();
                        return;
                    }

                    // 1. Ubah state tombol (Blokir interaksi lebih lanjut)
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');

                    // 2. Tambahkan atribut Aksesibilitas
                    btn.setAttribute('aria-disabled', 'true');
                    btn.setAttribute('aria-busy', 'true');

                    // 3. Tampilkan spinner dan perbarui teks
                    spinner.classList.remove('hidden');
                    text.textContent = 'Menyimpan...';

                    // Form akan otomatis melanjutkan proses submit bawaan ke server
                });
            }
        });
    </script>
</x-app-layout>