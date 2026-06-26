<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Master Wilayah') }}</h2>
            <a href="{{ route('wilayah.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium">+ Tambah Wilayah</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="space-y-4">
                    @forelse($provinsi as $prov)
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h3 class="font-bold text-lg text-indigo-700">{{ $prov->nama_provinsi }}</h3>
                            <div class="mt-3 pl-4 space-y-3">
                                @foreach($prov->kabupaten as $kab)
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $kab->nama_kabupaten }}</p>
                                        <div class="ml-4 mt-1 text-sm text-gray-600 grid grid-cols-2 md:grid-cols-3 gap-2">
                                            @foreach($kab->kecamatan as $kec)
                                                <div class="border-l-2 border-gray-300 pl-2">
                                                    <p class="font-medium">{{ $kec->nama_kecamatan }}</p>
                                                    <ul class="text-xs text-gray-500">
                                                        @foreach($kec->kelurahan as $kel)
                                                            <li>- {{ $kel->nama_kelurahan }} (Pos: {{ $kel->kode_pos }})</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-500">Belum ada data wilayah.</div>
                    @endforelse
                </div>
                <div class="mt-4">{{ $provinsi->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>