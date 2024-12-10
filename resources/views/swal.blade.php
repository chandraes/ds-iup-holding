{{-- <script src="{{asset('assets/vendor_components/sweetalert/sweetalert.min.js')}}"></script> --}}
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil !!',
        text: '{{session('success')}}',
        timer: null, // Menambahkan opsi ini untuk mencegah Swal.fire menutup sendiri
        showConfirmButton: true
    });
</script>
@endif
@if (session('error'))
<script>
   Swal.fire({
        icon: 'error',
        title: 'Gagal !!',
        text: '{{session('error')}}',
        timer: null, // Menambahkan opsi ini untuk mencegah Swal.fire menutup sendiri
        showConfirmButton: true
    })
</script>
@endif
@if ($errors->any())
@php
    $message='';
    foreach ($errors->all() as $error){
        $message .= $error;
    }
@endphp
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal !!',
        text: '{{$message}}',
        timer: null, // Menambahkan opsi ini untuk mencegah Swal.fire menutup sendiri
        showConfirmButton: true
    })
</script>
@endif
