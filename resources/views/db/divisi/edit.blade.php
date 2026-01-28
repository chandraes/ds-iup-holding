<x-modal name="editDivisiModal" :show="false" maxWidth="2xl">
    <div class="p-6"
         x-data="{ edit_nama: '', edit_url: '', edit_id: '' }"
         @set-divisi-data.window="edit_id = $event.detail.id; edit_nama = $event.detail.nama; edit_url = $event.detail.url">

        <h2 class="text-lg font-medium text-gray-900 mb-5">
            Edit Divisi
        </h2>
        <hr>
        <div class="my-3">
            <form :action="'{{ url('db/divisi/update') }}/' + edit_id" method="post" @submit.prevent="confirmEdit($event)">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <x-input-label for="edit_nama" :value="__('Nama Divisi')" />
                    <x-text-input id="edit_nama" class="block mt-1 w-full" type="text" name="nama"
                        x-model="edit_nama" required autofocus />
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <x-input-label for="edit_url" :value="__('URL Divisi')" />
                    <x-text-input id="edit_url" class="block mt-1 w-full" type="text" name="url"
                        x-model="edit_url" required />
                    <x-input-error :messages="$errors->get('url')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'editDivisiModal')">
                        {{ __('Batal') }}
                    </x-secondary-button>
                    <x-primary-button>
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>

<script>
    // GANTI NAMA FUNCTION AGAR TIDAK BENTROK
    function confirmEdit(event) {
        Swal.fire({
            title: 'Update Data?',
            text: "Perubahan akan disimpan.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Update!'
        }).then((result) => {
            if (result.isConfirmed) event.target.submit();
        });
    }
</script>
