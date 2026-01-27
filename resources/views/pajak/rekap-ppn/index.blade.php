<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-4xl text-gray-800 leading-tight">
            {{ __('REKAP PPN') }}
        </h1>
        {{-- nav bar link dengan menggunakan svg yang saya punya --}}

    </x-slot>
    <style>
        .dt-scroll-body thead {
            display: none !important;
        }
    </style>
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex flex-col p-5" data-hs-datatable='{
                        "paging": false,
                        "searching": false,
                        "ordering": false,
                        "info": false,
                        "scrollCollapse": true,
                        "scrollY": "400px"

                      }'>

                        <div class="flex items-center space-x-2 mb-4">
                            {{-- <div class="flex-0">
                                <div class="relative max-w-xs">
                                    <label for="hs-table-column-filter-search" class="sr-only">Search</label>
                                    <input type="text" name="hs-table-column-filter-search"
                                        id="hs-table-column-filter-search"
                                        class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        placeholder="Search for items" data-hs-datatable-search="">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                        <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.3-4.3"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class="flex-1 flex items-center justify-end space-x-2">
                                <!-- Select -->
                                <select class="hidden" data-hs-select='{
                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 px-3 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 before:absolute before:inset-0 before:z-[1]",
                            "dropdownClasses": "mt-2 z-50 w-20 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                            "optionClasses": "py-2 px-3 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                          }' data-hs-datatable-page-entities="">
                                    <option value="10" selected="">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                <!-- End Select -->
                            </div> --}}
                        </div>

                        <div class="overflow-x-auto min-h-[460px] ">
                            <div class="min-w-full inline-block align-middle">
                                <div class="overflow-hidden">
                                    <table class="min-w-full">
                                        @php
                                        $masuk = 0;
                                        $keluar = 0;
                                        $saldoSebelumnya = $dataSebelumnya ? $dataSebelumnya->saldo : 0;
                                        @endphp
                                        <thead >
                                            <tr class="border-b border-t border-gray-200 bg-green-100">
                                                <th scope="col"
                                                    class="py-2 px-3 text-center font-bold text-sm text-gray-500 --exclude-from-ordering border-2">
                                                    Tanggal</th>
                                                <th scope="col"
                                                    class="py-2 px-3 text-center font-bold text-sm text-gray-500 --exclude-from-ordering border-2">
                                                    Divisi</th>
                                                <th scope="col"
                                                    class="py-2 px-3 text-center font-bold text-sm text-gray-500 --exclude-from-ordering border-2">
                                                    Uraian</th>
                                                <th scope="col"
                                                    class="py-2 px-3 text-center font-bold text-sm text-gray-500 --exclude-from-ordering border-2">
                                                    Masuk</th>
                                                <th scope="col"
                                                    class="py-2 px-3 text-center font-bold text-sm text-gray-500 --exclude-from-ordering border-2">
                                                    Keluar</th>
                                                <th scope="col"
                                                    class="py-2 px-3 text-center font-bold text-sm text-gray-500 --exclude-from-ordering border-2">
                                                    Saldo</th>
                                            </tr>

                                        </thead>

                                        <tbody class="divide-y divide-gray-200">
                                            <tr class="border-b border-t border-gray-200 bg-yellow-100">
                                                 <td class="p-3 whitespace-nowrap text-center text-sm font-medium border">
                                                </td>
                                                <td class="p-3 whitespace-nowrap text-center text-sm font-medium ">
                                                    </td>
                                                    <td class="p-3 whitespace-nowrap text-center text-sm font-medium ">
                                                        </td>
                                                        <td class="p-3 whitespace-nowrap text-center text-sm font-medium ">
                                                            </td>
                                                <td class="p-3 whitespace-nowrap text-center text-sm font-medium ">
                                                    Saldo Sebelumnya</td>
                                                <th
                                                    class="py-2 px-3 text-end font-bold text-sm text-gray-500 --exclude-from-ordering border-2">
                                                    {{number_format($saldoSebelumnya,0,',','.')}}</th>
                                            </tr>
                                            @foreach ($data as $d)
                                            <tr>
                                                <td
                                                    class="p-3 whitespace-nowrap text-center text-sm font-medium border">
                                                    {{$d->tanggal}}</td>
                                                <td
                                                    class="p-3 whitespace-nowrap text-sm font-medium text-gray-800 border">
                                                    {{$d->divisi ? $d->divisi->nama : ''}}</td>
                                                <td class="p-3 text-sm text-gray-800 border ">
                                                    {{$d->uraian}}</td>
                                                <td class="p-3 whitespace-nowrap text-sm text-gray-800 border text-end">
                                                    {!!$d->jenis == 1 ? $d->nf_nominal : '&nbsp;0'!!}
                                                    @if ($d->jenis == 1)
                                                    @php
                                                    $masuk += $d->nominal;
                                                    @endphp
                                                    @endif
                                                </td>
                                                <td
                                                    class="p-3 whitespace-nowrap text-sm font-medium border text-end">
                                                    {!!$d->jenis == 0 ? $d->nf_nominal : '&nbsp;0'!!}
                                                    @if ($d->jenis == 0)
                                                    @php
                                                    $keluar += $d->nominal;
                                                    @endphp
                                                    @endif
                                                </td>
                                                <td
                                                    class="p-3 whitespace-nowrap text-sm font-medium border text-end">
                                                    {{$d->nf_saldo}}
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="p-3 whitespace-nowrap text-center text-sm font-medium border">
                                                    Total</td>
                                                <td class="p-3 whitespace-nowrap text-sm font-medium text-gray-800 border text-end">
                                                    {{$data->sum('masuk')}}</td>
                                                <td class="p-3 whitespace-nowrap text-sm font-medium text-gray-800 border text-end">
                                                    {{$data->sum('keluar')}}</td>
                                                <td class="p-3 whitespace-nowrap text-sm font-medium text-gray-800 border text-end">
                                                    {{number_format($saldoSebelumnya + $masuk - $keluar, 0, ',','.')}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="flex items-center space-x-1 pt-4 border-t border-gray-200 hidden"
                            data-hs-datatable-paging="">
                            <button type="button"
                                class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                                data-hs-datatable-paging-prev="">
                                <span aria-hidden="true">«</span>
                                <span class="sr-only">Previous</span>
                            </button>
                            <div class="flex items-center space-x-1 [&>.active]:bg-gray-100"
                                data-hs-datatable-paging-pages=""></div>
                            <button type="button"
                                class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                                data-hs-datatable-paging-next="">
                                <span class="sr-only">Next</span>
                                <span aria-hidden="true">»</span>
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(event) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this item?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }
    </script>
</x-app-layout>
