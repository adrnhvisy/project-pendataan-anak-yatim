<div class="pt-2">
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">1. Data Pribadi Anak</h3>
        <p class="mt-1 text-sm text-gray-500">Informasi biodata dasar anak yatim.</p>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
        <div class="sm:col-span-3">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
            <div class="mt-1">
                <input type="text" name="nama_lengkap" id="nama_lengkap"
                    value="{{ old('nama_lengkap', $anak->nama_lengkap ?? '') }}" required
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('nama_lengkap') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin *</label>
            <div class="mt-1">
                <select id="jenis_kelamin" name="jenis_kelamin" required
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    <option value="">Pilih...</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $anak->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $anak->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="nik" class="block text-sm font-medium text-gray-700">NIK (16 Digit) *</label>
            <div class="mt-1">
                <input type="text" name="nik" id="nik" value="{{ old('nik', $anak->nik ?? '') }}" required
                    maxlength="16"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('nik') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="no_kk" class="block text-sm font-medium text-gray-700">No. Kartu Keluarga (16 Digit) *</label>
            <div class="mt-1">
                <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk', $anak->no_kk ?? '') }}" required
                    maxlength="16"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('no_kk') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir *</label>
            <div class="mt-1">
                <input type="text" name="tempat_lahir" id="tempat_lahir"
                    value="{{ old('tempat_lahir', $anak->tempat_lahir ?? '') }}" required
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('tempat_lahir') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir *</label>
            <div class="mt-1">
                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                    value="{{ old('tanggal_lahir', $anak->tanggal_lahir ?? '') }}" required
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('tanggal_lahir') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Tambahkan di dalam form -->
        <div class="mb-4">
            <x-input-label for="foto_anak" value="Foto Anak (Opsional)" />
            <input type="file" name="foto_anak" id="foto_anak"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="sm:col-span-3">
            <label for="status_anak" class="block text-sm font-medium text-gray-700">Status Anak *</label>
            <div class="mt-1">
                <select id="status_anak" name="status_anak" required
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    <option value="">Pilih...</option>
                    <option value="Yatim" {{ old('status_anak', $anak->status_anak ?? '') == 'Yatim' ? 'selected' : '' }}>
                        Yatim</option>
                    <option value="Piatu" {{ old('status_anak', $anak->status_anak ?? '') == 'Piatu' ? 'selected' : '' }}>
                        Piatu</option>
                    <option value="Yatim Piatu" {{ old('status_anak', $anak->status_anak ?? '') == 'Yatim Piatu' ? 'selected' : '' }}>Yatim Piatu</option>
                </select>
                @error('status_anak') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="no_rekening" class="block text-sm font-medium text-gray-700">No. Rekening Bank
                (Opsional)</label>
            <div class="mt-1">
                <input type="text" name="no_rekening" id="no_rekening"
                    value="{{ old('no_rekening', $anak->no_rekening ?? '') }}"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error('no_rekening') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>