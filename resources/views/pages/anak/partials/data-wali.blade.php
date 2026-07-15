<div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden">
    <div class="px-6 py-4 border-b border-[#e5eeff] bg-[#f8f9ff]">
        <h3 class="text-lg font-bold text-[#0b1c30]">4. Data Wali (Opsional)</h3>
        <p class="text-xs text-[#737686] mt-1">Isi data wali jika anak tidak tinggal bersama orang tua.</p>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="nama_wali" value="Nama Wali" />
            <x-text-input id="nama_wali" name="nama_wali" type="text"
                class="mt-1 block w-full border-[#E2E8F0] focus:border-[#004ac6] focus:ring-[#004ac6]"
                value="{{ old('nama_wali', $anak->wali->nama ?? '') }}" placeholder="Masukkan nama lengkap wali" />
        </div>
        <div x-data="{ nikWali: '{{ old('nik_wali', $anak->wali->nik ?? '') }}' }">
            <!-- Label -->
            <x-input-label for="nik_wali" class="text-[#434655] font-semibold">
                NIK Wali 
            </x-input-label>

            <!-- Input Field -->
            <x-text-input id="nik_wali" name="nik_wali" type="text" x-model="nikWali" x-bind:class="{ 
                      'border-red-500 focus:border-red-500 focus:ring-red-500': nikWali.length > 0 && (nikWali.length !== 16 || !/^\d+$/.test(nikWali)), 
                      'border-green-500 focus:border-green-500 focus:ring-green-500': nikWali.length === 16 && /^\d+$/.test(nikWali) 
                  }"
                class="mt-1 block w-full border-[#E2E8F0] focus:border-[#004ac6] focus:ring-[#004ac6] rounded-lg transition-colors duration-200"
                value="{{ old('nik_wali', $anak->wali->nik ?? '') }}" placeholder="16 digit NIK"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" />

            <!-- Pesan Peringatan Real-Time -->
            <p x-show="nikWali.length > 0 && (nikWali.length !== 16 || !/^\d+$/.test(nikWali))"
                class="text-red-500 text-xs mt-1">
                NIK harus tepat 16 digit angka.
            </p>

            <p x-show="nikWali.length === 16 && /^\d+$/.test(nikWali)" class="text-green-600 text-xs mt-1">
                NIK valid.
            </p>

            <!-- Error Handling Laravel (Server-Side) -->
            @error('nik_wali')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <x-input-label for="hubungan_wali" value="Hubungan dengan Anak" />
            <x-text-input id="hubungan_wali" name="hubungan_wali" type="text"
                class="mt-1 block w-full border-[#E2E8F0] focus:border-[#004ac6] focus:ring-[#004ac6]"
                value="{{ old('hubungan_wali', $anak->wali->hubungan_dengan_anak ?? '') }}"
                placeholder="Contoh: Paman, Kakek" />
        </div>
        <div>
            <x-input-label for="pekerjaan_wali" value="Pekerjaan Wali" />
            <x-text-input id="pekerjaan_wali" name="pekerjaan_wali" type="text"
                class="mt-1 block w-full border-[#E2E8F0] focus:border-[#004ac6] focus:ring-[#004ac6]"
                value="{{ old('pekerjaan_wali', $anak->wali->pekerjaan ?? '') }}" placeholder="Pekerjaan wali" />
        </div>
    </div>
</div>