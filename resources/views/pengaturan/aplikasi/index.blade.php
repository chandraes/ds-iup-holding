<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-4xl text-gray-800 leading-tight">
            {{ __('APLIKASI') }}
        </h1>
        {{-- nav bar link dengan menggunakan svg yang saya punya --}}

    </x-slot>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between m-3">
                    <div class="w-full">
                        <table class="w-full gap-2 md:w-1/2 table-auto">
                            <tr class="text-center">
                                <td class="p-2">
                                    <a href="{{route('dashboard')}}" class="flex items-center">
                                        <img src="{{asset('images/dashboard.svg')}}" alt="dashboard"
                                            class="w-8 h-8 mr-2">
                                        <span class="text-sky-500 hover:text-sky-700 text-sm">Dashboard</span>
                                    </a>
                                </td>
                                <td class="p-2">
                                    <a href="{{route('pengaturan')}}" class="flex items-center">
                                        <img src="{{asset('images/back.svg')}}" alt="dokumen" class="w-8 h-8 mr-2">
                                        <span class="text-sky-500 hover:text-sky-700 text-sm">Kembali</span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    {{-- form input nama dan upload logo --}}
                    <form x-data @submit.prevent="confirmSubmission($event)" action="{{route('pengaturan.aplikasi.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div class="mb-3">
                                <x-input-label for="nama" :value="__('Nama Aplikasi')" />
                                <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama"
                                    :value="$data->nama ?? old('nama')" required autofocus autocomplete="nama" />
                                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                            </div>
                            <div class="mb-3">
                                <x-input-label for="logo" :value="__('Logo')" />
                                <div class="flex items-center justify-center w-full">
                                    <label for="logo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-3"></i>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (max. 800x400px)</p>
                                        </div>
                                        <input id="logo" name="logo" type="file" class="hidden" accept="image/*" onchange="previewImage(event)" />
                                    </label>
                                </div>
                                <div id="preview-container" class="mt-3 hidden">
                                    <img id="preview-image" class="max-w-full h-auto rounded-lg" />
                                </div>
                                <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <x-primary-button class="m-2">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    function previewImage(event) {
        const input = event.target;
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
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
</x-app-layout>
