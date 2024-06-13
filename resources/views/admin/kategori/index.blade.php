@extends('layout.sidebar')

@section('search')
<div class="search">
    <form action="{{route('cats.index')}}" method="POST" id="serach">
        @csrf
        <label>
            <input type="text" placeholder="Search Here" name="search" id="search" onabort="event.preventDefault();
                         document.getElementById('serach').submit();
                     ">
            <ion-icon name="search"></ion-icon>

        </label>
    </form>
</div>
@endsection
@section('content')

<!-- Cards-->
<div class="CardBox">
    <div class="Card">
        <div>
            <div class="numbers">{{$catsCount}}</div>
            <div class="CardName">Kategori</div>
        </div>
        <div class="iconBox"><ion-icon name="albums"></ion-icon></div>
    </div>
    <div class="Card">
        <div>
            <div class="numbers">{{$sales}}</div>
            <div class="CardName">Penjualan</div>
        </div>
        <div class="iconBox">
            <ion-icon name="basket"></ion-icon>
        </div>
    </div>
    <div class="Card">
        <div>
            <div class="numbers">{{$MenusCount}}</div>
            <div class="CardName">Menu</div>
        </div>
        <div class="iconBox">
            <ion-icon name="clipboard"></ion-icon>
        </div>
    </div>
    <div class="Card">
        <div>
            <div class="numbers">Rp {{$Earning}}</div>
            <div class="CardName">Pendapatan</div>
        </div>
        <div class="iconBox">
            <ion-icon name="cash"></ion-icon>
        </div>
    </div>
</div>
{{-- kategori list --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="div-header d-flex flex-row justify-content-between align-item-center border-bottom p-2">
                        <h3>
                            <ion-icon name="list"></ion-icon>
                        </h3>
                        <a href="{{route("kategori.create")}}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <!--- details Lists --->
                    <div class="cat-details">
                        <!--- category details List -->
                        <div class="list">
                            <div class="cartHeader">
                                <h2>Kategori</h2>
                                <a href="/kategori" class="btn">Lihat semua</a>
                            </div>
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <td>#ID</td>
                                            <td>Judul</td>
                                            <td>Aktif</td>
                                            <td class="text-center">Action</td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($cats as $cat)
                                        <tr>
                                            <td>{{$cat->id}}</td>
                                            <td>{{$cat->judul}}</td>
                                            <td>
                                                @if ($cat->aktif)
                                                <i class="fa fa-check text-success"></i>

                                                @else
                                                <i class="fa fa-times text-danger"></i>

                                                @endif
                                            </td>
                                            <td class="d-flex flex-row justify-content-center align-items-center ">
                                                <a href="{{route('kategori.edit',$cat->id)}}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                                {{-- delete form --}}
                                                <form id="{{$cat->id}}" action="{{route("kategori.destroy",$cat->id)}}" method="post" style="margin-left: 4px !important">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" onclick="event.preventDefault();

                                                                    Swal.fire({
                                                                    title: 'Apakah Anda Yakin?',
                                                                    text: 'Apakah Anda ingin menghapus kategori? {{$cat->judul}}',
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#3085d6',
                                                                    cancelButtonColor: '#d33',
                                                                    confirmButtonText: 'Yes, delete it!'
                                                                    }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        document.getElementById('{{$cat->id}}').submit();
                                                                        Swal.fire(
                                                                        'Deleted!',
                                                                        'kategori telah dihapus.',
                                                                        'success'
                                                                        )
                                                                    }
                                                                    })
                                                               ">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>


                        </div>

                    </div>
                    {{-- Pagination --}}
                    <div class="justify-content-center d-flex">
                        {{$cats->links("pagination::bootstrap-4")}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection


    @section('script')
    @endsection