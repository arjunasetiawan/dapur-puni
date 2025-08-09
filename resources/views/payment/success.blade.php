@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="container mt-5 text-center">
    <div class="card shadow-lg p-5 rounded">
        <h2 class="text-success mb-4">🎉 Pembayaran Berhasil!</h2>
        <p class="lead">Terima kasih sudah berbelanja di <strong>Dapur Puni</strong>.</p>
        <p>Pesanan kamu sedang kami proses dan akan segera dikirim.</p>

        <a href="{{ route('myorders') }}" class="btn btn-success mt-4">
            Lihat Pesanan Saya
        </a>
    </div>
</div>
@endsection
