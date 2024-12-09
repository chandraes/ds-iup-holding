<x-modal name="editModal" :show="false" maxWidth="2xl">
    <div class="p-6" x-data="{ edit_nama: '', edit_url: '' }" @open-modal.window="if ($event.detail.id === 'editModal') { edit_nama = $event.detail.edit_nama; edit_url = $event.detail.edit_url; show = true; }">
        <h2 class="text-lg font-medium text-gray-900 mb-5">
            Edit Divisi
        </h2>
        <hr>
        <div class="my-3">
            <form @submit.prevent="confirmSubmission($event)" method="post">
                @csrf
                <div class="mb-3">
                    <x-input-label for="nama" :value="__('Nama Divisi')" />
                    <x-text-input id="edit_nama" class="block mt-1 w-full" type="text" name="nama" x-model="edit_nama" required autofocus autocomplete="nama" />
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>
                <div class="mb-3">
                    <x-input-label for="url" :value="__('URL Divisi')" />
                    <x-text-input id="edit_url" class="block mt-1 w-full" type="text" name="url" x-model="edit_url" required autofocus autocomplete="url" />
                    <x-input-error :messages="$errors->get('url')" class="mt-2" />
                </div>
                <div class="mt-6 flex justify-end">
                    <x-primary-button class="m-2">
                        {{ __('Update') }}
                    </x-primary-button>
                    <x-secondary-button class="m-2" x-on:click="$dispatch('close-modal', 'editModal')">
                        {{ __('Close') }}
                    </x-secondary-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>
<script>
    function confirmSubmission(event) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to submit the form?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }
</script>
