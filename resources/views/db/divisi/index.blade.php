@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <h1><u>KATEGORI SATUAN</u></h1>
        </div>
    </div>
    <div class="flex-row justify-content-between mt-3">
        <div class="col-md-6">
            <table class="table" id="data-table">
                <tr>
                    <td><a href="{{route('home')}}"><img src="{{asset('images/dashboard.svg')}}" alt="dashboard"
                                width="30"> Dashboard</a></td>
                    <td><a href="{{route('db')}}"><img src="{{asset('images/database.svg')}}" alt="dokumen" width="30">
                            Database</a></td>
                    <td><a href="#" data-bs-toggle="modal" data-bs-target="#createCustomer"><img
                                src="{{asset('images/divisi.svg')}}" width="30"> Tambah Divisi</a>

                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@include('db.divisi.create')
@include('db.divisi.edit')
<div class="container mt-5 table-responsive">
    <table class="table table-bordered table-hover" id="data">
        <thead class="table-success bg-gradient">
            <tr>
                <th class="text-center align-middle" style="width: 5%">NO</th>
                <th class="text-center align-middle">Nama Divisi</th>
                <th class="text-center align-middle">URL</th>
                <th class="text-center align-middle">Token</th>
                <th class="text-center align-middle">ACT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr>
                <td class="text-center align-middle">{{$loop->iteration}}</td>
                <td class="text-center align-middle">{{$d->nama}}</td>
                <td class="text-center align-middle">{{$d->url}}</td>
                <td class="text-center align-middle">{{$d->token}}</td>
                <td class="text-center align-middle">
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal"
                            data-bs-target="#editProject" onclick="editProject({{$d}}, {{$d->id}})"><i
                                class="fa fa-edit"></i></button>
                        <form action="{{ route('db.divisi.delete', $d->id) }}" method="post" id="deleteForm{{ $d->id }}"
                            class="delete-form" data-id="{{ $d->id }}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger m-2"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('js')
<script>

    confirmAndSubmit('#masukForm', 'Apakah Data yang anda masukan sudah benar?');
    confirmAndSubmit('#editForm', 'Apakah Data yang anda masukan sudah benar?');

    $('.delete-form').submit(function(e){
        e.preventDefault();
        var formId = $(this).data('id');
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, simpan!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#deleteForm${formId}`).unbind('submit').submit();
                $('#spinner').show();
            }
        });
    });

    function editProject(data, id) {
        document.getElementById('edit_nama').value = data.nama;
        document.getElementById('edit_url').value = data.url;
        document.getElementById('editForm').action = '/db/divisi/' + id;
    };


    $('#data').DataTable({
        paging: false,
        scrollCollapse: true,
        scrollY: "550px",
    });


</script>
@endpush
