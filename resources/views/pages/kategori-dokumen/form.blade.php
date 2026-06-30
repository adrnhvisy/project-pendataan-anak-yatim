@csrf
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium">Nama Dokumen</label>
        <input type="text" name="nama_dokumen" value="{{ old('nama_dokumen', $kategoriDokumen->nama_dokumen ?? '') }}" class="w-full mt-1 border-[#E2E8F0] rounded-lg" required>
        @error('nama_dokumen') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
    </div>
    <div class="flex items-center">
        <input type="checkbox" name="is_wajib" value="1" {{ old('is_wajib', $kategoriDokumen->is_wajib ?? false) ? 'checked' : '' }} class="h-4 w-4 rounded text-[#004ac6]">
        <label class="ml-2 block text-sm">Dokumen Wajib</label>
    </div>
</div>