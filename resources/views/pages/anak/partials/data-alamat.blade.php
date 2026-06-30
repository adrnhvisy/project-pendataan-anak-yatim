<div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden">
    <div class="px-6 py-4 border-b border-[#e5eeff] bg-[#f8f9ff]">
        <h3 class="text-lg font-bold text-[#0b1c30]">2. Lokasi Domisili</h3>
        <p class="text-xs text-[#737686] mt-1">Data lokasi otomatis terikat dengan wilayah kerja Anda.</p>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="md:col-span-4">
            <x-input-label for="alamat_lengkap" value="Alamat Lengkap" />
            <x-text-input id="alamat_lengkap" name="alamat_lengkap" type="text" class="mt-1 block w-full border-[#E2E8F0] focus:border-[#004ac6]" value="{{ old('alamat_lengkap', $anak->alamatDomisili->alamat_lengkap ?? '') }}" required />
        </div>
        <div>
            <x-input-label for="rt" value="RT" />
            <x-text-input id="rt" name="rt" type="text" class="mt-1 block w-full border-[#E2E8F0] focus:border-[#004ac6]" value="{{ old('rt', $anak->alamatDomisili->rt ?? '') }}" required />
        </div>
        <div>
            <x-input-label for="rw" value="RW" />
            <x-text-input id="rw" name="rw" type="text" class="mt-1 block w-full border-[#E2E8F0] focus:border-[#004ac6]" value="{{ old('rw', $anak->alamatDomisili->rw ?? '') }}" required />
        </div>
        <div class="md:col-span-2">
            <x-input-label value="Kelurahan (Otomatis Wilayah Anda)" />
            <div class="mt-1 block w-full p-2.5 bg-gray-100 border border-gray-300 rounded-md text-sm text-gray-600 font-medium">
                {{ auth()->user()->kelurahan->nama_kelurahan ?? 'Kelurahan tidak diatur' }}
            </div>
            </div>
    </div>
</div>