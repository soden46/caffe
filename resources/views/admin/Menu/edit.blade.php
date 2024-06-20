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
                                 <h3><i class="fas fa fa-edit"></i> Edit Menu</h3>
                            </div>
                            <div class="card-body">
                              <form action="{{route('Menu.update',$menu->id)}}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row mb-3">
                                     <label for="judul" class="col-md-2 col-sm-3 form-label">Judu:</label>
                                     <input type="text"
                                            id="judul"
                                            name="judul"
                                            class="col form-control"
                                            value="{{$menu->judul}}"
                                     >
                                </div>
                               <div class="row form-floating mb-3">
                                    <textarea class="form-control" name="deskripsi" id="floatingTextarea">{{$menu->deskripsi}}</textarea>
                                    <label for="floatingTextarea">Deskripsi</label>
                                </div>
                                <div class="row mb-3">
                                     <label for="harga" class="col-md-2 col-sm-3 form-label">Harga </label>
                                    <div class="input-group ">
                                            <input type="text" class="form-control" name="harga" value="{{$menu->harga}}" id="harga">
                                             <span class="input-group-text">IDR</span>
                                    </div>
                                </div>
                                <div class="row input-group mb-3">
                                    <label for="harga_lama" class="col-md-2 col-sm-3 form-label">Harga Lama</label>
                                   <div class="input-group ">
                                        <input type="text" class="form-control" name="harga_lama" value="{{$menu->harga_lama}}" id="harga_lama" >
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
                                    <label for="id_kategori" class="col-md-2 col-sm-3 form-label">Category</label>
                                    <select class="form-select" name="categorie_id" aria-label="Default select example" id="id_kategori">
                                        @foreach ($kategori as $cat)
                                           <option value="{{$cat->id}}" {{$menu->id_kategori == $cat->id ? 'selected' : ''}} >{{$cat->judul}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                        <label for="promo" class="col-md-2 col-sm-3 form-label">Promo</label>
                                        <select class="form-select" name="promo" id="promo">
                                            <option value="0" {{ $menu->promo == 0 ? 'selected' : '' }}>Tidak</option>
                                            <option value="1" {{ $menu->promo == 1 ? 'selected' : '' }}>Iya</option>
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
