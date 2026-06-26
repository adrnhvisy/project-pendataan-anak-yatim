<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Tambah Role Baru</h2></x-slot>
    <div class="py-12"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow sm:rounded-lg">
        <form action="{{ route('master.roles.store') }}" method="POST">
            @csrf
            @include('pages.roles.form')
            <div class="mt-6 flex justify-end"><button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan Role</button></div>
        </form>
    </div></div>
</x-app-layout>