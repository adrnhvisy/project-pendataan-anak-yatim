<div class="pt-8">
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">4. Data Wali (Opsional)</h3>
        <p class="mt-1 text-sm text-gray-500">Kosongkan jika anak tinggal bersama orang tua kandung yang masih hidup.</p>
    </div>
    
    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
        <div class="sm:col-span-2">
            <label for="nama_wali" class="block text-sm font-medium text-gray-700">Nama Wali</label>
            <div class="mt-1">
                <input type="text" name="nama_wali" id="nama_wali" value="{{ old('nama_wali', $anak->wali->nama ?? '') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('nama_wali') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="nik_wali" class="block text-sm font-medium text-gray-700">NIK Wali</label>
            <div class="mt-1">
                <input type="text" name="nik_wali" id="nik_wali" value="{{ old('nik_wali', $anak->wali->nik ?? '') }}" maxlength="16" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('nik_wali') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="hubungan_wali" class="block text-sm font-medium text-gray-700">Hubungan dengan Anak</label>
            <div class="mt-1">
                <input type="text" name="hubungan_wali" id="hubungan_wali" value="{{ old('hubungan_wali', $anak->wali->hubungan_dengan_anak ?? '') }}" placeholder="Contoh: Paman, Nenek, Kakak" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('hubungan_wali') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>