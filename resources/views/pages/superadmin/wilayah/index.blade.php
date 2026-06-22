<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Master Data: Wilayah</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Daftar Wilayah Pelalawan</h3>
            
            <div class="space-y-4" x-data="{ open: null }">
                @foreach($provinsi as $prov)
                    @foreach($prov->kabupaten as $kab)
                        @foreach($kab->kecamatan as $kec)
                            <div class="border rounded-lg overflow-hidden">
                                <button @click="open = (open === {{ $kec->id }} ? null : {{ $kec->id }})" 
                                        class="w-full px-4 py-3 bg-gray-50 flex justify-between items-center hover:bg-gray-100">
                                    <span class="font-medium text-gray-700">Kecamatan: {{ $kec->nama_kecamatan }}</span>
                                    <span>▼</span>
                                </button>
                                <div x-show="open === {{ $kec->id }}" class="px-4 py-2 bg-white">
                                    <ul class="list-disc ml-5 text-sm text-gray-600">
                                        @foreach($kec->kelurahan as $kel)
                                            <li>{{ $kel->nama_kelurahan }} (Kode Pos: {{ $kel->kode_pos }})</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>