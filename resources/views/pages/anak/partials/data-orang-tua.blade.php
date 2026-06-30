<div class="space-y-6">
    <div class="border-b border-[#E2E8F0] pb-4">
        <h3 class="text-lg font-bold text-[#0b1c30]">3. Data Orang Tua Kandung</h3>
        <p class="text-sm text-[#434655]">Informasi Ayah dan Ibu kandung anak untuk keperluan pendataan.</p>
    </div>
    
    @php
        // Pastikan variabel $anak sudah ada. Kita ambil koleksi orang tua lalu filter.
        $orangTua = isset($anak) ? $anak->orangTua : collect();
        $ayah = $orangTua->where('jenis_orang_tua', 'Ayah')->first();
        $ibu = $orangTua->where('jenis_orang_tua', 'Ibu')->first();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl border border-[#E2E8F0] shadow-sm">
            <h4 class="font-bold text-md text-[#0b1c30] mb-4 border-b pb-2">Data Ayah</h4>
            <div class="space-y-4">
                <div>
                    <label for="nama_ayah" class="block text-sm font-semibold text-[#434655]">Nama Ayah <span class="text-[#EF4444]">*</span></label>
                    <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah', $ayah->nama ?? '') }}" required 
                        class="mt-1 block w-full rounded-lg border-[#E2E8F0] shadow-sm focus:border-[#004ac6] focus:ring-[#004ac6] sm:text-sm">
                    @error('nama_ayah') <p class="mt-1 text-sm text-[#EF4444]">{{ $message }}</p> @enderror
                </div>

                <div x-data="{ nikAyah: '{{ old('nik_ayah', $ayah->nik ?? '') }}' }">
                    <label for="nik_ayah" class="block text-sm font-semibold text-[#434655]">NIK Ayah <span class="text-[#EF4444]">*</span></label>
                    <input type="text" name="nik_ayah" id="nik_ayah" x-model="nikAyah" required maxlength="16"
                        x-bind:class="{ 
                            'border-red-500 focus:border-red-500 focus:ring-red-500': nikAyah.length > 0 && (nikAyah.length !== 16 || !/^\d+$/.test(nikAyah)), 
                            'border-green-500 focus:border-green-500 focus:ring-green-500': nikAyah.length === 16 && /^\d+$/.test(nikAyah),
                            'border-[#E2E8F0]': nikAyah.length === 0 
                        }"
                        class="mt-1 block w-full rounded-lg shadow-sm sm:text-sm transition-colors duration-200">
                    <p x-show="nikAyah.length > 0 && (nikAyah.length !== 16 || !/^\d+$/.test(nikAyah))" class="mt-1 text-sm text-[#EF4444]">NIK harus 16 digit angka.</p>
                    <p x-show="nikAyah.length === 16 && /^\d+$/.test(nikAyah)" class="mt-1 text-sm text-green-600">NIK valid.</p>
                    @error('nik_ayah') <p class="mt-1 text-sm text-[#EF4444]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="pekerjaan_ayah" class="block text-sm font-semibold text-[#434655]">Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $ayah->pekerjaan ?? '') }}" 
                        class="mt-1 block w-full rounded-lg border-[#E2E8F0] shadow-sm focus:border-[#004ac6] focus:ring-[#004ac6] sm:text-sm">
                </div>

                <div>
                    <label for="status_hidup_ayah" class="block text-sm font-semibold text-[#434655]">Status Hidup <span class="text-[#EF4444]">*</span></label>
                    <select id="status_hidup_ayah" name="status_hidup_ayah" required 
                        class="mt-1 block w-full rounded-lg border-[#E2E8F0] shadow-sm focus:border-[#004ac6] focus:ring-[#004ac6] sm:text-sm">
                        <option value="">Pilih Status...</option>
                        <option value="Meninggal" {{ old('status_hidup_ayah', $ayah->status_hidup ?? '') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                        <option value="Hidup" {{ old('status_hidup_ayah', $ayah->status_hidup ?? '') == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-[#E2E8F0] shadow-sm">
            <h4 class="font-bold text-md text-[#0b1c30] mb-4 border-b pb-2">Data Ibu</h4>
            <div class="space-y-4">
                <div>
                    <label for="nama_ibu" class="block text-sm font-semibold text-[#434655]">Nama Ibu <span class="text-[#EF4444]">*</span></label>
                    <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu', $ibu->nama ?? '') }}" required 
                        class="mt-1 block w-full rounded-lg border-[#E2E8F0] shadow-sm focus:border-[#004ac6] focus:ring-[#004ac6] sm:text-sm">
                    @error('nama_ibu') <p class="mt-1 text-sm text-[#EF4444]">{{ $message }}</p> @enderror
                </div>

                <div x-data="{ nikIbu: '{{ old('nik_ibu', $ibu->nik ?? '') }}' }">
                    <label for="nik_ibu" class="block text-sm font-semibold text-[#434655]">NIK Ibu <span class="text-[#EF4444]">*</span></label>
                    <input type="text" name="nik_ibu" id="nik_ibu" x-model="nikIbu" required maxlength="16"
                        x-bind:class="{ 
                            'border-red-500 focus:border-red-500 focus:ring-red-500': nikIbu.length > 0 && (nikIbu.length !== 16 || !/^\d+$/.test(nikIbu)), 
                            'border-green-500 focus:border-green-500 focus:ring-green-500': nikIbu.length === 16 && /^\d+$/.test(nikIbu),
                            'border-[#E2E8F0]': nikIbu.length === 0 
                        }"
                        class="mt-1 block w-full rounded-lg shadow-sm sm:text-sm transition-colors duration-200">
                    <p x-show="nikIbu.length > 0 && (nikIbu.length !== 16 || !/^\d+$/.test(nikIbu))" class="mt-1 text-sm text-[#EF4444]">NIK harus 16 digit angka.</p>
                    <p x-show="nikIbu.length === 16 && /^\d+$/.test(nikIbu)" class="mt-1 text-sm text-green-600">NIK valid.</p>
                    @error('nik_ibu') <p class="mt-1 text-sm text-[#EF4444]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="pekerjaan_ibu" class="block text-sm font-semibold text-[#434655]">Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $ibu->pekerjaan ?? '') }}" 
                        class="mt-1 block w-full rounded-lg border-[#E2E8F0] shadow-sm focus:border-[#004ac6] focus:ring-[#004ac6] sm:text-sm">
                </div>

                <div>
                    <label for="status_hidup_ibu" class="block text-sm font-semibold text-[#434655]">Status Hidup <span class="text-[#EF4444]">*</span></label>
                    <select id="status_hidup_ibu" name="status_hidup_ibu" required 
                        class="mt-1 block w-full rounded-lg border-[#E2E8F0] shadow-sm focus:border-[#004ac6] focus:ring-[#004ac6] sm:text-sm">
                        <option value="">Pilih Status...</option>
                        <option value="Meninggal" {{ old('status_hidup_ibu', $ibu->status_hidup ?? '') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                        <option value="Hidup" {{ old('status_hidup_ibu', $ibu->status_hidup ?? '') == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>