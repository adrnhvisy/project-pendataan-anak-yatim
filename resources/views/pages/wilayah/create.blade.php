<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Tambah Hirarki Wilayah</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow sm:rounded-lg">
            <form action="{{ route('master.wilayah.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Nama Provinsi</label>
                    <input type="text" name="nama_provinsi" required class="mt-1 block w-full border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium">Nama Kabupaten</label>
                    <input type="text" name="nama_kabupaten" required class="mt-1 block w-full border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium">Nama Kecamatan</label>
                    <input type="text" name="nama_kecamatan" required class="mt-1 block w-full border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium">Nama Kelurahan</label>
                    <input type="text" name="nama_kelurahan" required class="mt-1 block w-full border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium">Kode Pos</label>
                    <input type="text" name="kode_pos" maxlength="5" required class="mt-1 block w-full border-gray-300 rounded-md">
                </div>
                <div class="pt-4">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">Simpan Wilayah</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>