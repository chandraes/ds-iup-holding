<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-4xl text-gray-800 leading-tight">
            {{ __('DIVISI') }}
        </h1>
    </x-slot>

    @include('db.divisi.create')
    @include('db.divisi.edit')

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="bg-white p-4 shadow-sm sm:rounded-lg flex flex-wrap gap-4 items-center justify-between">
                <div class="flex gap-4">
                    <a href="{{route('dashboard')}}" class="flex items-center gap-2 text-sky-500 hover:text-sky-700 font-medium text-sm">
                        <img src="{{asset('images/dashboard.svg')}}" class="w-6 h-6"> Dashboard
                    </a>
                    <a href="{{route('db')}}" class="flex items-center gap-2 text-sky-500 hover:text-sky-700 font-medium text-sm">
                        <img src="{{asset('images/back.svg')}}" class="w-6 h-6"> Kembali
                    </a>

                    <button x-data @click="$dispatch('open-modal', 'createDivisiModal')"
                            class="flex items-center gap-2 text-sky-500 hover:text-sky-700 font-medium text-sm cursor-pointer">
                        <img src="{{asset('images/divisi.svg')}}" class="w-6 h-6"> Tambah Divisi
                    </button>
                </div>
            </div>

            <div class="bg-white p-4 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('db.divisi') }}" class="flex justify-between items-center">
                    <div class="relative w-full max-w-xs">
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500 text-sm pl-10"
                               placeholder="Cari divisi...">
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Divisi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Token</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($data as $d)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$d->nama}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$d->url}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $d->token }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center items-center gap-2">
                                        <button type="button"
                                                x-data
                                                @click="$dispatch('open-modal', 'editDivisiModal'); $dispatch('set-divisi-data', { id: '{{ $d->id }}', nama: '{{ $d->nama }}', url: '{{ $d->url }}' })"
                                                class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 p-2 rounded-md transition cursor-pointer">
                                            <i class="fa fa-pencil"></i>
                                        </button>

                                        <form x-data @submit.prevent="confirmDelete($event)" action="{{ route('db.divisi.delete', $d->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 p-2 rounded-md transition cursor-pointer">
                                                <i class="fa fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-10 text-center text-gray-500">Data kosong.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t border-gray-200">{{ $data->links() }}</div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(event) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) event.target.submit();
            });
        }
    </script>
</x-app-layout>
