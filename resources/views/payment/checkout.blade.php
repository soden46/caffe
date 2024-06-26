@extends('layout.payment')

@section('title', 'Pembayaran')

@section('content')
    <div class="small-container cart-page">
        <div class="card text-center" style="width: 400px; height: 400px; margin: 4rem auto 0;">
            <!-- Isi konten pembayaran di sini -->
            <div class="box-container">
                <div class="box">
                    <div class="content">
                        <h3 class="sub-heading">Pembayaran</h3>
                        <span>Osaka Billiard Dan Cafe Yogyakarta Adalah Tempat billiard berstandar internasional</span>
                        <span>memiliki sejumlah ciri dan fasilitas yang membuatnya berbeda dari tempat billiard biasa</span>
                        </br>
                        <button type="submit" class="btn btn-success mt-3 justify-content-center" id="pay-button">Bayar
                            Sekarang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
