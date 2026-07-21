<div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden">
    <div class="px-6 py-4 border-b border-[#e5eeff] bg-[#f8f9ff]">
        <h3 class="text-lg font-bold text-[#0b1c30]">5. Dokumen Anak</h3>
        <p class="text-sm text-[#434655] mt-1">Unggah dokumen pendukung sesuai persyaratan. Pastikan dokumen yang diunggah jelas dan terbaca.</p>
    </div>
    
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        @php
            $daftarKategori = isset($kategoriDokumen) ? $kategoriDokumen : \App\Models\KategoriDokumen::orderBy('nama_dokumen')->get();
        @endphp
        
        @foreach($daftarKategori as $kategori)
            {{-- 
                Logic: Kita inisialisasi state Alpine dengan data dari model (jika edit) 
                atau data yang dipertahankan oleh session (jika validasi gagal).
            --}}
            @php
                // Cek apakah ada data dokumen yang sudah tersimpan atau dari session
                $existingFile = isset($anak) ? $anak->dokumen()->where('kategori_dok_id', $kategori->id)->first() : null;
            @endphp

            <div x-data="{ 
                    preview: '{{ $existingFile ? asset('storage/' . $existingFile->file_path) : null }}', 
                    fileName: '{{ $existingFile ? basename($existingFile->file_path) : null }}',
                    isLoading: false,
                    handleFile(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.isLoading = true;
                            this.preview = null;
                            this.fileName = file.name;

                            setTimeout(() => {
                                if (file.type.startsWith('image/')) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => { 
                                        this.preview = e.target.result; 
                                        this.isLoading = false;
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    this.preview = 'doc';
                                    this.isLoading = false;
                                }
                            }, 600);
                        }
                    }
                 }" 
                 class="border border-[#e5eeff] rounded-xl p-5 bg-white shadow-sm hover:border-[#004ac6] transition-all relative">
                
                <div class="flex justify-between items-start mb-3">
                    <label for="dokumen_{{ $kategori->id }}" class="block font-bold text-sm text-[#0b1c30]">
                        {{ $kategori->nama_dokumen }}
                    </label>
                    
                    @if($kategori->is_wajib)
                        <span class="px-2 py-1 bg-red-50 text-red-700 text-[10px] uppercase font-bold rounded border border-red-100">Wajib</span>
                    @else
                        <span class="px-2 py-1 bg-gray-50 text-gray-600 text-[10px] uppercase font-bold rounded border border-gray-200">Opsional</span>
                    @endif
                </div>

                {{-- Preview Box - Akan muncul jika ada file baru atau file lama (dari DB/Edit) --}}
                <div x-show="preview || fileName" class="mb-3 p-3 bg-gray-50 rounded-lg flex items-center gap-3 border border-dashed border-gray-300 relative overflow-hidden">
                    
                    {{-- Spinner Loading Overlay --}}
                    <div x-show="isLoading" class="absolute inset-0 bg-white/80 flex items-center justify-center z-10 backdrop-blur-sm">
                        <svg class="animate-spin h-6 w-6 text-[#004ac6]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </div>

                    {{-- Konten Preview --}}
                    <div class="w-12 h-12 rounded overflow-hidden flex-shrink-0 bg-white border border-gray-200 flex items-center justify-center">
                        {{-- Jika preview adalah URL gambar --}}
                        <img x-show="preview && preview !== 'doc'" :src="preview" class="w-full h-full object-cover">
                        {{-- Icon dokumen jika bukan gambar --}}
                        <svg x-show="preview === 'doc' || (!preview && fileName)" class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="truncate">
                        <p class="text-xs font-bold text-[#0b1c30] truncate" x-text="fileName"></p>
                        <p class="text-[10px] text-green-600 font-medium">Dokumen siap</p>
                    </div>
                </div>
                
                <div class="mt-2">
                    <input type="file" 
                           id="dokumen_{{ $kategori->id }}" 
                           name="dokumen[{{ $kategori->id }}]" 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           @change="handleFile($event)"
                           class="block w-full text-sm text-gray-600 
                                  file:mr-4 file:py-2 file:px-4 
                                  file:rounded-lg file:border-0 
                                  file:text-sm file:font-semibold 
                                  file:bg-[#e5eeff] file:text-[#004ac6] 
                                  hover:file:bg-[#dce9ff] 
                                  border border-[#E2E8F0] rounded-lg cursor-pointer bg-gray-50 
                                  focus:outline-none focus:border-[#004ac6] focus:ring-[#004ac6]" 
                           {{ ($kategori->is_wajib && !$existingFile) ? : '' }}>
                </div>
                
                <p class="text-[11px] text-gray-400 mt-2">Format: PDF, JPG, PNG. Maks: 3MB.</p>
                
                @error('dokumen.' . $kategori->id)
                    <div class="text-sm text-red-600 mt-3 flex items-center bg-red-50 p-2 rounded-md border border-red-100">
                        <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>
        @endforeach
    </div>
</div>