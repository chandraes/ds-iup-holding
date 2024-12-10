<x-modal name="editModal" :show="false" maxWidth="2xl">
    <div class="p-6" x-data="{ edit_name: '', edit_username: '', edit_role: '', edit_id: '' }" @open-modal.window="if ($event.detail.id === 'editModal') { edit_name = $event.detail.edit_name; edit_username = $event.detail.edit_username; edit_role = $event.detail.edit_role; edit_id = $event.detail.edit_id; show = true; }">
        <h2 class="text-lg font-medium text-gray-900 mb-5">
            Edit Pengguna
        </h2>
        <hr>
        <div class="my-3">
            <form :action="'/pengaturan/akun/' + edit_id" method="post" @submit.prevent="confirmSubmission($event)">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <div class="mb-3">
                        <x-input-label for="name" :value="__('Nama')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" x-model="edit_name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <x-input-label for="username" :value="__('Username')" />
                        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" x-model="edit_username"
                            :value="old('username')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <x-input-label for="role" :value="__('Role')" />
                        <select name="role" id="role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" x-model='edit_role'>
                            <option value="">-- Pilih Salah Satu --</option>
                            @foreach ($roles as $role)
                            <option value="{{$role}}">{{$role}}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>
                    <div x-data="{ show_password: false }" class="mb-3 relative">
                        <x-input-label for="password" :value="__('Password')" />
                        <input :type="show_password ? 'text' : 'password'" id="password" class="block mt-1 w-full pr-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="password" autofocus autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <button type="button" @click="show_password = !show_password" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            <i :class="show_password ? 'fas fa-eye-slash' : 'fas fa-eye'" class="h-5 w-5 text-gray-500 pt-3"></i>
                        </button>
                    </div>
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
