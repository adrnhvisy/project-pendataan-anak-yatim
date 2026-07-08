<div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden">
    <div class="px-6 py-4 border-b border-[#e5eeff] bg-[#f8f9ff]">
        <h3 class="text-lg font-bold text-[#0b1c30]">1. Biodata Anak</h3>
    </div>

    <div class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <x-input-label for="nama_lengkap" class="text-[#434655] font-semibold">
                Nama Lengkap <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="nama_lengkap" name="nama_lengkap" type="text"
                class="mt-2 block w-full border-[#E2E8F0] focus:border-[#004ac6] focus:ring-[#004ac6] rounded-lg"
                value="{{ old('nama_lengkap', $anak->nama_lengkap ?? '') }}" required />
            @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div x-data="{ nik: '{{ old('nik', $anak->nik ?? '') }}' }">
            <x-input-label for="nik" class="text-[#434655] font-semibold">
                NIK (16 Digit) <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="nik" name="nik" type="text" inputmode="numeric" maxlength="16"
                class="mt-2 block w-full border-[#E2E8F0] focus:border-[#004ac6] focus:ring-[#004ac6] rounded-lg"
                x-model="nik" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />

            <p class="text-xs mt-1 font-medium transition-colors duration-200"
                :class="nik.length === 16 ? 'text-green-600' : (nik.length > 0 ? 'text-amber-600' : 'text-gray-500')">
                <span x-show="nik.length > 0 && nik.length < 16">NIK kurang <span x-text="16 - nik.length"></span> digit lagi</span>
                <span x-show="nik.length === 16">✓ NIK valid (16 digit)</span>
                <span x-show="nik.length > 16">NIK terlalu panjang!</span>
            </p>

            @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div x-data="{ no_kk: '{{ old('no_kk', $anak->no_kk ?? '') }}' }">
            <x-input-label for="no_kk" class="text-[#434655] font-semibold">
                Nomor Kartu Keluarga <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="no_kk" name="no_kk" type="text" inputmode="numeric" maxlength="16"
                class="mt-2 block w-full border-[#E2E8F0] focus:border-[#004ac6] focus:ring-[#004ac6] rounded-lg"
                x-model="no_kk" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />

            <p class="text-xs mt-1 font-medium transition-colors duration-200"
                :class="no_kk.length === 16 ? 'text-green-600' : (no_kk.length > 0 ? 'text-amber-600' : 'text-gray-500')">
                <span x-show="no_kk.length > 0 && no_kk.length < 16">KK kurang <span x-text="16 - no_kk.length"></span> digit lagi</span>
                <span x-show="no_kk.length === 16">✓ Nomor KK valid (16 digit)</span>
                <span x-show="no_kk.length > 16">Nomor KK terlalu panjang!</span>
            </p>

            @error('no_kk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div x-data="{ rek: '{{ old('no_rekening', $anak->no_rekening ?? '') }}' }">
            <x-input-label for="no_rekening" value="Nomor Rekening (Opsional)" class="text-[#434655] font-semibold" />
            <x-text-input id="no_rekening" name="no_rekening" type="text" inputmode="numeric"
                class="mt-2 block w-full border-[#E2E8F0] focus:border-[#004ac6] focus:ring-[#004ac6] rounded-lg"
                x-model="rek" oninput="this.value = this.value.replace(/[^0-9]/g, '')" />

            <p class="text-xs mt-1 text-gray-500 font-medium" x-show="rek.length > 0">
                <span x-text="rek.length"></span> digit terinput
            </p>

            @error('no_rekening') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-input-label for="tempat_lahir" class="text-[#434655] font-semibold">
                Tempat Lahir <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="tempat_lahir" name="tempat_lahir" type="text"
                class="mt-2 block w-full border-[#E2E8F0] focus:border-[#004ac6] focus:ring-[#004ac6] rounded-lg"
                value="{{ old('tempat_lahir', $anak->tempat_lahir ?? '') }}" required />
            @error('tempat_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-input-label for="tanggal_lahir" class="text-[#434655] font-semibold">
                Tanggal Lahir <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date"
                class="mt-2 block w-full border-[#E2E8F0] focus:border-[#004ac6] focus:ring-[#004ac6] rounded-lg"
                value="{{ old('tanggal_lahir', $anak->tanggal_lahir ?? '') }}" required />
            @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-input-label for="jenis_kelamin" class="text-[#434655] font-semibold">
                Jenis Kelamin <span class="text-red-500">*</span>
            </x-input-label>
            <select id="jenis_kelamin" name="jenis_kelamin"
                class="mt-2 block w-full border-[#E2E8F0] rounded-lg shadow-sm focus:border-[#004ac6] focus:ring-[#004ac6] text-[#434655]"
                required>
                <option value="Laki-laki" {{ old('jenis_kelamin', $anak->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $anak->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div>
            <x-input-label for="status_anak" class="text-[#434655] font-semibold">
                Status Anak <span class="text-red-500">*</span>
            </x-input-label>
            <select id="status_anak" name="status_anak"
                class="mt-2 block w-full border-[#E2E8F0] rounded-lg shadow-sm focus:border-[#004ac6] focus:ring-[#004ac6] text-[#434655]"
                required>
                <option value="Yatim" {{ old('status_anak', $anak->status_anak ?? '') == 'Yatim' ? 'selected' : '' }}>Yatim</option>
                <option value="Piatu" {{ old('status_anak', $anak->status_anak ?? '') == 'Piatu' ? 'selected' : '' }}>Piatu</option>
                <option value="Yatim Piatu" {{ old('status_anak', $anak->status_anak ?? '') == 'Yatim Piatu' ? 'selected' : '' }}>Yatim Piatu</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <x-input-label for="catatan" value="Catatan Admin Kelurahan (Kondisi Anak, dll)" class="text-[#434655] font-semibold" />
            <textarea id="catatan" name="catatan" rows="3"
                class="mt-2 block w-full border-[#E2E8F0] rounded-lg shadow-sm focus:border-[#004ac6] focus:ring-[#004ac6]"
                placeholder="Masukkan keterangan tambahan kondisi anak jika ada...">{{ old('catatan', $anak->catatan ?? '') }}</textarea>
            @error('catatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</div>