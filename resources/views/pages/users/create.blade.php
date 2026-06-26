<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Tambah User Baru</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <form action="{{ route('master.users.store') }}" method="POST" class="p-6">
                    @csrf
                    @include('pages.users.form')
                    <div class="mt-6 flex justify-end"><button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>