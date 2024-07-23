@extends('layout.app')
@section('title', 'Daftar Transaksi')
@section('content')
    <!-- cart item -->
    <div class="small-container cart-page mb-4">
        <div class="container">
            <h1>Daftar Transaksi</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Menu</th>
                        <th>Quantity</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Status Pembayaran</th>
                        <th>Bukti Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->nama_menu }}</td>
                            <td>{{ $transaction->qty }}</td>
                            <td>Rp {{ number_format($transaction->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                            <td>
                                @if ($transaction->dibayar)
                                    <span class="text-success">Sudah Dibayar</span>
                                @else
                                    <span class="text-danger">Belum Dibayar</span>
                                @endif
                            </td>
                            <td>
                                @if ($transaction->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $transaction->bukti_pembayaran) }}" target="_blank">Lihat
                                        Bukti</a>
                                @else
                                    Tidak ada bukti
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.invoice', $transaction->id) }}" class="btn btn-primary">Invoice</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
