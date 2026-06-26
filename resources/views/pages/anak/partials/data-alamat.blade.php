<div class="pt-8">
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">2. Alamat Domisili</h3>
        <p class="mt-1 text-sm text-gray-500">Alamat lengkap tempat anak tinggal saat ini.</p>
    </div>
    
    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
        <div class="sm:col-span-6">
            <label for="alamat_lengkap" class="block text-sm font-medium text-gray-700">Alamat Lengkap (Jalan / Gang / No Rumah) *</label>
            <div class="mt-1">
                <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('alamat_lengkap', $anak->alamatDomisili->alamat_lengkap ?? '') }}</textarea>
                @error('alamat_lengkap') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="rt" class="block text-sm font-medium text-gray-700">RT *</label>
            <div class="mt-1">
                <input type="text" name="rt" id="rt" value="{{ old('rt', $anak->alamatDomisili->rt ?? '') }}" required maxlength="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md placeholder-gray-400" placeholder="001">
                @error('rt') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="rw" class="block text-sm font-medium text-gray-700">RW *</label>
            <div class="mt-1">
                <input type="text" name="rw" id="rw" value="{{ old('rw', $anak->alamatDomisili->rw ?? '') }}" required maxlength="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md placeholder-gray-400" placeholder="002">
                @error('rw') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan *</label>
            <div class="mt-1">
                <select id="kelurahan_id" name="kelurahan_id" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    <option value="">Pilih Kelurahan...</option>
                    @foreach($kelurahan as $kel)
                        <option value="{{ $kel->id }}" {{ old('kelurahan_id', $anak->alamatDomisili->kelurahan_id ?? '') == $kel->id ? 'selected' : '' }}>{{ $kel->nama_kelurahan }}</option>
                    @endforeach
                </select>
                @error('kelurahan_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>