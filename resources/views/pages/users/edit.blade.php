<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit User: {{ $user->name }}</h2>
    </x-slot>
    <div class="py-12">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-6">
                    @csrf @method('PUT')
                    @include('pages.users.form', ['user' => $user])
                    <div class="mt-6 flex justify-end"><button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded">Perbarui</button></div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>