<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0b1c30]">Pengaturan Sistem</h2>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div
                    class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm animate-fade-in">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-6">
                @foreach ($pengaturan as $item)
                    <div
                        class="bg-white p-6 rounded-xl border border-[#e5eeff] shadow-sm hover:border-[#cbdbf5] transition-all">
                        {{-- Perhatikan penambahan enctype multipart/form-data untuk mendukung upload file/gambar --}}
                        <form action="{{ route('pengaturan.update', $item->id) }}" method="POST" class="form-pengaturan"
                            enctype="multipart/form-data">
                            @csrf @method('PUT')

                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-sm font-bold text-[#004ac6] uppercase tracking-wider">
                                        {{ str_replace('_', ' ', $item->key) }}</h3>
                                    <p class="text-xs text-[#737686] mt-1 italic">
                                        {{ $item->keterangan ?? 'Key: ' . $item->key }}</p>
                                </div>

                                <div class="flex-1 min-w-[200px]">
                                    @if($item->tipe === 'boolean')
                                        <select name="value"
                                            class="w-full border-[#E2E8F0] rounded-lg focus:ring-[#004ac6] focus:border-[#004ac6] text-sm">
                                            <option value="1" {{ $item->value == '1' ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ $item->value == '0' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                    @elseif($item->tipe === 'text')
                                        <textarea name="value" rows="2"
                                            class="w-full border-[#E2E8F0] rounded-lg focus:ring-[#004ac6] focus:border-[#004ac6] text-sm">{{ old('value', $item->value) }}</textarea>
                                    @elseif($item->tipe === 'image')
                                        @if($item->value)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $item->value) }}" alt="Logo"
                                                    class="h-16 w-auto rounded border p-1 bg-gray-50">
                                            </div>
                                        @endif
                                        <input type="file" name="value" accept="image/*"
                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#e5eeff] file:text-[#004ac6] hover:file:bg-[#dce9ff]">
                                    @elseif($item->tipe === 'file')
                                        @if($item->value)
                                            <div class="mb-3">
                                                <a href="{{ asset('storage/' . $item->value) }}" target="_blank"
                                                    class="inline-flex items-center gap-2 text-sm text-[#004ac6] hover:underline bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                    Lihat Panduan Saat Ini
                                                </a>
                                            </div>
                                        @endif
                                        <input type="file" name="value" accept=".pdf,.doc,.docx"
                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#e5eeff] file:text-[#004ac6] hover:file:bg-[#dce9ff]">
                                    @else
                                        <input type="text" name="value" value="{{ old('value', $item->value) }}"
                                            class="w-full border-[#E2E8F0] rounded-lg focus:ring-[#004ac6] focus:border-[#004ac6] text-sm">
                                    @endif
                                </div>

                                <div class="flex-shrink-0">
                                    <button type="submit"
                                        class="btn-submit px-5 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-bold hover:bg-blue-800 transition flex items-center gap-2">
                                        <span class="btn-text">Simpan</span>
                                        <svg class="spinner hidden w-4 h-4 animate-spin" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.form-pengaturan').forEach(form => {
            form.addEventListener('submit', function () {
                const btn = this.querySelector('.btn-submit');
                const text = this.querySelector('.btn-text');
                const spinner = this.querySelector('.spinner');

                // Beri jeda sangat singkat agar UI merespons sebelum proses submit
                setTimeout(() => {
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                    text.innerText = 'Proses...';
                    spinner.classList.remove('hidden');
                }, 50);
            });
        });
    </script>
</x-app-layout>