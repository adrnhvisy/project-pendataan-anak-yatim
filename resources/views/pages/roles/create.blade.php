<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-[#0b1c30]">Tambah Role</h2></x-slot>
    <div class="py-12 bg-[#f8f9ff]">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('roles.store') }}" method="POST" class="bg-white p-6 rounded-xl border border-[#e5eeff]">
                @include('pages.roles.form')
                <button type="submit" class="mt-4 px-4 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layout>