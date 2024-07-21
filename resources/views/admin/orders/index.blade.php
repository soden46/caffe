@extends('layout.sidebar')

@section('search')
    <div class="search">
        <form action="{{ route('orders.search') }}" method="POST" id="serach">
            @csrf
            <label>
                <input type="text" placeholder="Search Here" name="search" id="search"
                    onabort="event.preventDefault(); document.getElementById('serach').submit();">
                <ion-icon name="search"></ion-icon>
            </label>
        </form>
    </div>
@endsection

@section('content')
    <!-- Cards -->
    <div class="CardBox">
        <!-- Card Content Here -->
    </div>

    <!-- Orders List -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="div-header d-flex flex-row justify-content-between align-item-center border-bottom p-2">
                            <h3>
                                <ion-icon name="list"></ion-icon>
                            </h3>
                        </div>
                        <!-- Details Lists -->
                        <div class="cat-details">
                            <div class="list">
                                <div class="cartHeader">
                                    <h2>Transaksi</h2>
                                    @if (Route::currentRouteName() == 'orders.archive')
                                        <a href="{{ route('orders.index') }}" class="btn">Lihat Transaksi</a>
                                    @else
                                        <a href="{{ route('orders.archive') }}" class="btn">Lihat Arsip Transaksi</a>
                                    @endif
                                </div>
                                <div class="table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <td>#ID</td>
                                                <td>Pelanggan</td>
                                                <td>Menu</td>
                                                <td>Quantity</td>
                                                <td>Harga</td>
                                                <td>Total</td>
                                                <td>Dibayar</td>
                                                <td>Bukti Pembayaran</td>
                                                <td>Diantar</td>
                                                <td class="text-center">Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->user->nama }}</td>
                                                    <td>{{ $order->nama_menu }}</td>
                                                    <td>{{ $order->qty }}</td>
                                                    <td>Rp. {{ $order->harga }}</td>
                                                    <td>Rp. {{ $order->total }}</td>
                                                    <td>
                                                        @if ($order->dibayar)
                                                            <i class="fa fa-check text-success"></i>
                                                        @else
                                                            <i class="fa fa-close text-danger"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($order->bukti_pembayaran)
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#buktiPembayaranModal"
                                                                data-img-url="{{ asset('uploads/' . $order->bukti_pembayaran) }}">
                                                                <img src="{{ asset('uploads/' . $order->bukti_pembayaran) }}"
                                                                    alt="Bukti Pembayaran" class="img-thumbnail"
                                                                    width="100">
                                                            </a>
                                                        @else
                                                            Tidak ada bukti
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($order->diantar)
                                                            <i class="fa fa-check text-success"></i>
                                                        @else
                                                            <i class="fa fa-close text-danger"></i>
                                                        @endif
                                                    </td>
                                                    <td class="d-flex flex-row justify-content-center align-items-center">
                                                        <!-- Action Buttons Here -->
                                                    </td>
                                                </tr>

                                                <!-- Modal -->
                                                <div class="modal fade" id="buktiPembayaranModal" tabindex="-1"
                                                    role="dialog" aria-labelledby="buktiPembayaranModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="buktiPembayaranModalLabel">Bukti
                                                                    Pembayaran</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img id="buktiPembayaranImage" src=""
                                                                    alt="Bukti Pembayaran" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Pagination -->
                        <div class="justify-content-center d-flex">
                            {{ $orders->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#buktiPembayaranModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var imgUrl = button.data('img-url');
                    var modal = $(this);
                    modal.find('#buktiPembayaranImage').attr('src', imgUrl);
                });
            });
        </script>
    @endsection
