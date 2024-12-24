@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-12 text-center">
            <h1><u>PENGATURAN APLIKASI</u></h1>
        </div>
    </div>
    @include('swal')
    <div class="flex-row justify-content-between mt-3">
        <div class="col-md-4">
            <table class="table">
                <tr class="text-center">
                    <td><a href="{{route('home')}}"><img src="{{asset('images/dashboard.svg')}}" alt="dashboard"
                                width="30"> Dashboard</a></td>
                    <td><a href="{{route('pengaturan')}}"><img src="{{asset('images/pengaturan.svg')}}" alt="dokumen"
                                width="30"> Pengaturan</a></td>
                </tr>
            </table>
        </div>
    </div>
    <hr>
    <div class="row mt-3">
        <form action="{{route('pengaturan.aplikasi.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Aplikasi</label>
                        <input type="text" class="form-control" name="nama" id="nama" aria-describedby="helpId"
                            placeholder="" value="{{$data ? $data->nama : ''}}" required/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" name="logo" id="logo" placeholder="logo"
                            aria-describedby="fileHelpId" />
                    </div>
                </div>
            </div>
            {{-- button submit --}}
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Simpan <i class="fa fa-save ms-2"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('js')
<script>
    function edit(data, id)
   {
        document.getElementById('nilai').value = data.nf_nilai;
        // Populate other fields...
        document.getElementById('editForm').action = '/pengaturan/batasan/update/' + id;

   }

   confirmAndSubmit('#editForm', "Apakah anda yakin?");
</script>
@endpush
