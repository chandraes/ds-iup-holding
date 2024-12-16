<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-4xl text-gray-800 leading-tight">
            {{ __('DASHBOARD') }}
        </h1>
    </x-slot>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-2 gap-2 sm:grid-cols-4 place-items-center">
                    <div class="p-4 flex flex-col items-center">
                        <a href="{{route('db')}}" class="text-decoration-none flex flex-col items-center">
                            <img src="{{ asset('images/database.svg') }}" alt="" width="70">
                            <h4 class="mt-2 text-sky-500 hover:text-sky-700">DATABASE</h4>
                        </a>
                    </div>
                    <div class="p-4 flex flex-col items-center">
                        <a href="{{route('pajak.rekap-ppn')}}" class="text-decoration-none flex flex-col items-center">
                            <img src="{{ asset('images/rekap-ppn.svg') }}" alt="" width="70">
                            <h4 class="mt-2 text-sky-500 hover:text-sky-700">REKAP PPN</h4>
                        </a>
                    </div>
                    <div class="p-4 flex flex-col items-center">
                        <a href="{{route('rekap')}}" class="text-decoration-none flex flex-col items-center">
                            <img src="{{ asset('images/rekap.svg') }}" alt="" width="70">
                            <h4 class="mt-2 text-sky-500 hover:text-sky-700">REKAP</h4>
                        </a>
                    </div>
                    <div class="p-4 flex flex-col items-center">
                        <a href="{{route('pengaturan')}}" class="text-decoration-none flex flex-col items-center">
                            <img src="{{ asset('images/pengaturan.svg') }}" alt="" width="70">
                            <h4 class="mt-2 text-sky-500 hover:text-sky-700">PENGATURAN</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
