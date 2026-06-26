<div class="pt-8">
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">3. Data Orang Tua Kandung</h3>
        <p class="mt-1 text-sm text-gray-500">Informasi Ayah dan Ibu kandung anak.</p>
    </div>
    
    @php
        // Helper extract data untuk form Edit
        $ayah = isset($anak) ? $anak->orangTua->where('jenis_orang_tua', 'Ayah')->first() : null;
        $ibu = isset($anak) ? $anak->orangTua->where('jenis_orang_tua', 'Ibu')->first() : null;
    @endphp

    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 border-b border-gray-100 pb-6">
        <div class="sm:col-span-6"><h4 class="font-medium text-gray-700">Data Ayah</h4></div>
        
        <div class="sm:col-span-2">
            <label for="nama_ayah" class="block text-sm font-medium text-gray-700">Nama Ayah *</label>
            <div class="mt-1">
                <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah', $ayah->nama ?? '') }}" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('nama_ayah') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="nik_ayah" class="block text-sm font-medium text-gray-700">NIK Ayah *</label>
            <div class="mt-1">
                <input type="text" name="nik_ayah" id="nik_ayah" value="{{ old('nik_ayah', $ayah->nik ?? '') }}" required maxlength="16" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('nik_ayah') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="status_hidup_ayah" class="block text-sm font-medium text-gray-700">Status Hidup *</label>
            <div class="mt-1">
                <select id="status_hidup_ayah" name="status_hidup_ayah" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    <option value="">Pilih...</option>
                    <option value="Meninggal" {{ old('status_hidup_ayah', $ayah->status_hidup ?? '') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                    <option value="Hidup" {{ old('status_hidup_ayah', $ayah->status_hidup ?? '') == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                </select>
                @error('status_hidup_ayah') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
        <div class="sm:col-span-6"><h4 class="font-medium text-gray-700">Data Ibu</h4></div>

        <div class="sm:col-span-2">
            <label for="nama_ibu" class="block text-sm font-medium text-gray-700">Nama Ibu *</label>
            <div class="mt-1">
                <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu', $ibu->nama ?? '') }}" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('nama_ibu') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="nik_ibu" class="block text-sm font-medium text-gray-700">NIK Ibu *</label>
            <div class="mt-1">
                <input type="text" name="nik_ibu" id="nik_ibu" value="{{ old('nik_ibu', $ibu->nik ?? '') }}" required maxlength="16" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('nik_ibu') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="status_hidup_ibu" class="block text-sm font-medium text-gray-700">Status Hidup *</label>
            <div class="mt-1">
                <select id="status_hidup_ibu" name="status_hidup_ibu" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    <option value="">Pilih...</option>
                    <option value="Meninggal" {{ old('status_hidup_ibu', $ibu->status_hidup ?? '') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                    <option value="Hidup" {{ old('status_hidup_ibu', $ibu->status_hidup ?? '') == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                </select>
                @error('status_hidup_ibu') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>