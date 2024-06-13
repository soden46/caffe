@extends('layout.sidebar')

@section('content')

{{-- Categories list --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="card-title margin-bottom">
                            <h3><i class="fas fa fa-list"></i> Tambah Kategori</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('kategori.store')}}" method="post">
                                @csrf
                                <div class="row mb-3">
                                    <label for="judul" class="col-md-2 col-sm-3 form-label">Judul:</label>
                                    <input type="text" id="judul" name="judul" class="col form-control" placeholder="Masukan Judul Kategori">
                                </div>

                                <div class="row mb-3">
                                    <label for="aktif">Pilih Status</label>
                                    <select class="form-control" id="aktif" name="aktif">
                                        <option value="" selected>Pilih Status</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <input type="submit" value="Send" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @endsection

    @section('script')
    @endsection