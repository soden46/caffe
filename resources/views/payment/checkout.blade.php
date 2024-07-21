@extends('layout.payment')

@section('title', 'Invoice Pembayaran')

@section('content')
    <style>
        .large-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 100%;
            min-height: 100vh;
        }

        .card {
            width: 100%;
            max-width: 600px;
            margin: 4rem auto;
            padding: 4rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .invoice-header,
        .invoice-details {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .detail-item {
            margin-bottom: 1rem;
        }

        .transaction-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .transaction-details,
        .qr-code {
            width: 48%;
        }

        .qr-code img {
            justify-content: center;
            width: 100%;
            max-width: 120px;
        }
    </style>

    <div class="large-container">
        <div class="card text-center">
            <!-- Header Invoice -->
            <div class="invoice-header">
                <h2 class="heading">Invoice Pembayaran</h2>

            </div>

            <!-- Detail Transaksi dan QR Code -->
            <div class="transaction-container">
                <!-- Detail Transaksi -->
                <div class="transaction-details">
                    <h3 class="sub-heading">Detail Pembelian</h3>
                    <p class="sub-heading-2">Nomor Invoice: {{ $invoiceId }}</p>
                    <p class="sub-heading-2">Tanggal: {{ $invoiceDate->format('d-m-Y H:i') }}</p>
                    <p class="sub-heading-2">Nama: {{ $user->nama }}</p>
                    <p class="sub-heading-2">Email: {{ $user->email }}</p>
                    @foreach ($items as $item)
                        <p class="sub-heading-2">Barang: {{ $item['name'] }}</p>
                        <p class="sub-heading-2">Harga: Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        <p class="sub-heading-2">Total Barang: {{ $item['quantity'] }}</p>
                        <p class="sub-heading-2">Total Harga: Rp
                            {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}</p>
                    @endforeach
                </div>

                <!-- QR Code -->
                <div class="qr-code">
                    <h3 class="sub-heading">Qr Code Pembayaran</h3>
                    <img src="{{ asset('images/qr.jpg') }}" alt="QR Code Pembayaran">
                </div>

            </div>
            <div class="upload-bukti">
                <h3>Upload Bukti Pembayaran</h3>
                <form action="{{ route('transaksi.uploadBukti') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="id_user" class="form-control" value="{{ Auth::user()->id }}" hidden>
                    <input type="text" name="nama_menu" class="form-control" value="{{ $item['name'] }}" hidden>
                    <input type="text" name="qty" class="form-control" value="{{ $item['quantity'] }}" hidden>
                    <input type="number" name="harga" class="form-control" value="{{ $item['price'] }}" hidden>
                    <input type="number" name="total" class="form-control"
                        value="{{ $item['quantity'] * $item['price'] }}" hidden>
                    <input type="number" name="dibayar" class="form-control" value="1" hidden>
                    <input type="file" name="bukti_pembayaran" class="form-control" required>
                    <div>
                        <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
