<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('anak.index') }}" class="text-gray-500 hover:text-[#004ac6] transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">
                {{ __('Pendaftaran Anak Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-[#EF4444] text-[#EF4444] px-4 py-3 rounded-lg relative">
                    <strong class="font-bold">Terdapat kesalahan!</strong>
                    <ul class="mt-1 text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('anak.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @include('pages.anak.partials.form')

                <div class="flex justify-end bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff]">
                    <a href="{{ route('anak.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-[#E2E8F0] rounded-lg font-semibold text-xs text-[#434655] uppercase tracking-widest hover:bg-gray-50 mr-3">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#004ac6] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-[#004ac6] focus:ring-offset-2">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>