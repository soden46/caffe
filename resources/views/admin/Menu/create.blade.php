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
                                 <h3><i class="fas fa fa-list"></i> Tambah Menu Baru</h3>
                            </div>
                            <div class="card-body">
                              <form action="{{route('Menu.store')}}" method="post" enctype="multipart/form-data">
                               @csrf
                                <div class="row mb-3">
                                     <label for="judul" class="col-md-2 col-sm-3 form-label">Judul:</label>
                                     <input type="text"
                                            id="judul"
                                            name="judul"
                                            class="col form-control"
                                            placeholder="Masukan Judul menu "
                                     >
                                </div>
                               <div class="row form-floating mb-3">
                                    <textarea class="form-control" name="deskripsi" placeholder="Masukan Deskripsi menu" id="floatingTextarea"></textarea>
                                    <label for="floatingTextarea">Deskripsi</label>
                                </div>
                                <div class="row mb-3">
                                     <label for="harga" class="col-md-2 col-sm-3 form-label">Harga </label>
                                    <div class="input-group ">
                                            <input type="text" class="form-control" name="harga" id="harga" aria-label="Masukan Harga">
                                             <span class="input-group-text">IDR</span>
                                    </div>
                                </div>
                                <div class="row input-group mb-3">
                                    <label for="inputGroupFile02" class="col-md-2 col-sm-3 form-label">Foto</label>
                                    <div class="input-group ">
                                        <input type="file" class="form-control" name="foto" id="inputGroupFile02">
                                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="id_kategori" class="col-md-2 col-sm-3 form-label">Kategori</label>
                                    <select class="form-select" name="id_kategori" aria-label="Default select example" id="id_kategori">
                                        <option selected>Pilih Kategori</option>
                                        @foreach ($kategori as $cat)
                                           <option value="{{$cat->id}}">{{$cat->judul}}</option>
                                        @endforeach
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
