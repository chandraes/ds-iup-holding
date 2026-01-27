<x-modal name="editModal" :show="false" maxWidth="2xl">
    <div class="p-6" x-data="{ edit_untuk: '', edit_group_id: '',edit_nama_group: '', edit_id: '', }" @open-modal.window="if ($event.detail.id === 'editModal') { edit_untuk = $event.detail.edit_untuk; edit_group_id = $event.detail.edit_group_id; edit_nama_group = $event.detail.edit_nama_group; edit_id = $event.detail.edit_id; show = true; }">
        <h2 class="text-lg font-medium text-gray-900 mb-5">
            Edit Group Whatsapp
        </h2>
        <hr>
        <div class="my-3">
            <script src="https://unpkg.com/@popperjs/core@2"></script>
            <form :action="'/pengaturan/group-wa/' + edit_id" method="post" @submit.prevent="confirmSubmission($event)">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <div class="mb-3">
                        <x-input-label for="untuk" :value="__('Nama')" />
                        <x-text-input id="untuk" class="block mt-1 w-full" type="text" name="untuk" x-model="edit_untuk" disabled
                            :value="old('untuk')" required autofocus autocomplete="untuk" />
                        <x-input-error :messages="$errors->get('untuk')" class="mt-2" />
                    </div>
                    <input type="hidden" name="group_id" x-model="edit_group_id">
                    <div class="mb-3">
                        <x-input-label for="edit_group_id" :value="__('Group ID')" />
                        <div class="relative">
                            <select id="edit_nama_group" name="nama_group" x-model="edit_nama_group" @change="edit_group_id = $event.target.options[$event.target.selectedIndex].text" data-hs-select='{
                                {{-- "apiUrl": "{{route('pengaturan.group-wa.get-group-wa')}}",
                                "apiDataPart": "groups",
                                "apiQuery": "limit=10",
                                "apiSearchQueryKey": "q",
                                "apiFieldsMap": {
                                  "id": "id",
                                  "val": "id",
                                  "title": "name"
                                }, --}}
                                {{-- "hasSearch": true, --}}
                                  "dropdownScope": "window",
                                "searchPlaceholder": "Search...",
                                "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] py-2 px-3",
                                "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0",
                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-y-auto fixed",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                              }' class="hidden">
                                <option value="">Choose</option>
                              </select>


                            <div class="absolute top-1/2 end-2.5 -translate-y-1/2">
                              <svg class="shrink-0 size-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m7 15 5 5 5-5"></path>
                                <path d="m7 9 5-5 5 5"></path>
                              </svg>
                            </div>
                          </div>
                        <x-input-error :messages="$errors->get('group_id')" class="mt-2" />
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
