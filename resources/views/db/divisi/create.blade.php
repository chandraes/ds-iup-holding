<x-modal name="createDivisiModal" :show="false" maxWidth="2xl">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-5">
            Tambah Divisi Baru
        </h2>
        <hr>
        <div class="my-3">
            <form x-data @submit.prevent="confirmCreate($event)" action="{{route('db.divisi.store')}}" method="post">
                @csrf
                <div class="mb-3">
                    <x-input-label for="nama" :value="__('Nama Divisi')" />
                    <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus />
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>
                <div class="mb-3">
                    <x-input-label for="url" :value="__('URL Divisi')" />
                    <x-text-input id="url" class="block mt-1 w-full" type="text" name="url" :value="old('url')" required />
                    <x-input-error :messages="$errors->get('url')" class="mt-2" />
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'createDivisiModal')">
                        {{ __('Batal') }}
                    </x-secondary-button>
                    <x-primary-button>
                        {{ __('Simpan') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>

<script>
    // GANTI NAMA FUNCTION AGAR TIDAK BENTROK
    function confirmCreate(event) {
        Swal.fire({
            title: 'Simpan Data?',
            text: "Pastikan data sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!'
        }).then((result) => {
            if (result.isConfirmed) event.target.submit();
        });
    }
</script>
