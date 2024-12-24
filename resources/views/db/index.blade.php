@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1><u>DATABASE</u></h1>
</div>
<div class="container mt-5">
    <div class="row justify-content-left">
        <h2>Data Internal</h2>
        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'su')
        <div class="col-lg-2 col-md-2 col-sm-4 my-4 text-center">
            <a href="{{route('db.divisi')}}" class="text-decoration-none">
                <img src="{{asset('images/divisi.svg')}}" alt="" width="70">
                <h5 class="mt-2">DIVISI</h5>
            </a>
        </div>

    </div>
    <hr>
    <div class="row justify-content-left">
        <h2>Data Eksternal</h2>
        <div class="col-lg-2 col-md-2 col-sm-4 my-4 text-center">
            <a href="{{route('db.rekening')}}" class="text-decoration-none">
                <img src="{{asset('images/rekening.svg')}}" alt="" width="70">
                <h5 class="mt-2">REKENING<br>TRANSAKSI</h5>
            </a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 my-4 text-center">
            <a href="{{route('home')}}" class="text-decoration-none">
                <img src="{{asset('images/dashboard.svg')}}" alt="" width="70">
                <h5 class="mt-2">DASHBOARD</h5>
            </a>
        </div>
    </div>
    @endif
    {{-- <hr>
    <div class="row justify-content-left">
        <h2>Data Kategori</h2>
        <div class="col-lg-2 col-md-2 col-sm-4 my-4 text-center">
            <a href="{{route('db.cost-operational')}}" class="text-decoration-none">
                <img src="{{asset('images/cost-operational.svg')}}" alt="" width="70">
                <h5 class="mt-2">KATEGORI COST<br>OPERASIONAL</h5>
            </a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 my-4 text-center">
            <a href="{{route('db.kategori-inventaris')}}" class="text-decoration-none">
                <img src="{{asset('images/kategori-inventaris.svg')}}" alt="" width="70">
                <h5 class="mt-2">KATEGORI<br>INVENTARIS</h5>
            </a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 my-4 text-center">
            <a href="{{route('db.satuan')}}" class="text-decoration-none">
                <img src="{{asset('images/satuan.svg')}}" alt="" width="70">
                <h5 class="mt-2">KATEGORI<br>SATUAN</h5>
            </a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 my-4 text-center">
            <a href="{{route('db.kemasan-kategori')}}" class="text-decoration-none">
                <img src="{{asset('images/kategori-kemasan.svg')}}" alt="" width="70">
                <h5 class="mt-2">KATEGORI<br>BENTUK KEMASAN</h5>
            </a>
        </div>

    </div>
    <hr> --}}

</div>
@endsection
