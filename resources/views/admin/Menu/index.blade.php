@extends('layout.sidebar')


@section('search')
{{-- section shearch   --}}
<div class="search">
    <form action="{{route('menus.search')}}" method="POST" id="serach">
        @csrf
        <label>
            <input type="text" placeholder="Cari" name="search" id="search" onabort="event.preventDefault();
                         document.getElementById('serach').submit();
                     ">
            <ion-icon name="search"></ion-icon>

        </label>
    </form>
</div>
@endsection
@section('content')

<!-- Cards for statistics -->
<div class="CardBox">
    <div class="Card">
        <div>
            <div class="numbers">{{$PROMOMenusCount}}</div>
            <div class="CardName">Menu Promo</div>
        </div>
        <div class="iconBox">
            <ion-icon name="star"></ion-icon>
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
            <div class="numbers">{{$kategoriCount}}</div>
            <div class="CardName">Kategori</div>
        </div>
        <div class="iconBox"><ion-icon name="albums"></ion-icon></div>
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
{{-- Menu list --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="div-header d-flex flex-row justify-content-between align-item-center border-bottom p-2">
                        <h3>
                            <ion-icon name="list"></ion-icon>
                        </h3>
                        <a href="{{route("Menu.create")}}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <!--- details Lists --->
                    <div class="menu-details">
                        <!--- menu details List -->
                        <div class="list ">
                            <div class="cartHeader">
                                <h2>Menu</h2>
                                <a href="/Menu" class="btn">View All</a>
                            </div>
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <td>#ID</td>
                                            <td>Judul</td>
                                            <td>Deskripsi</td>
                                            <td>Harga</td>
                                            <td>Harga Lama</td>
                                            <td>Promo</td>
                                            <td>Foto</td>
                                            <td class="text-center">Action</td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($menus as $menu)
                                        <tr>
                                            <td>{{$menu->id}}</td>
                                            <td>{{$menu->judul}}</td>
                                            <td>{{Str::limit($menu->deskripsi,10)}}</td>
                                            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($menu->harga_lama, 0, ',', '.') }}</td>
                                             <td>{{$menu->promo == 1 ? 'Iya' : 'Tidak'}}</td>
                                            <td>
                                                <img src="{{asset('images//menu/'.$menu->foto)}}" alt="menu_image" class="img-fluid rounded-circle" width="70" height="70">
                                            </td>

                                            <td class="d-flex flex-row justify-content-center align-items-center ">
                                                <a href="{{route('Menu.edit',$menu->id)}}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                                {{-- delete form --}}
                                                <form id="{{$menu->id}}" action="{{route("Menu.destroy",$menu->id)}}" method="post" style="margin-left: 4px !important">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" onclick="event.preventDefault();

                                                                    Swal.fire({
                                                                    title: 'Apakah Anda yakin?',
                                                                    text: 'Apakah Anda ingin menghapus kategori {{$menu->title}}',
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#3085d6',
                                                                    cancelButtonColor: '#d33',
                                                                    confirmButtonText: 'Yes, delete it!'
                                                                    }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        document.getElementById('{{$menu->id}}').submit();
                                                                        Swal.fire(
                                                                        'Deleted!',
                                                                        'Kategori telah terhapus.',
                                                                        'success'
                                                                        )
                                                                    }
                                                                    })
                                                               ">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                                @if ($menu->promo === 0)
                                                <form action="{{route("menu.promo",$menu->id)}}" method="post" style="margin-left: 4px !important">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-pr btn-sm" type="submit" title="Ini Menu Promo">
                                                        <i class="fa-solid fa-fire text-white"></i>
                                                    </button>
                                                </form>
                                                @else
                                                <form action="{{route("menu.NONpromo",$menu->id)}}" method="post" style="margin-left: 4px !important">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-secondary btn-sm" type="submit" title="This Menu is no longer POPULAR">
                                                        <i class="fa-solid fa-dumpster-fire  text-white"></i>
                                                    </button>
                                                </form>
                                                @endif

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                                {{-- Menu Pagination--}}
                                <div class="justify-content-center d-flex">
                                    {{$menus->links("pagination::bootstrap-4")}}
                                </div>



                            </div>
                        </div>
                        {{-- Category  --}}
                        <div class="menu-category">
                            <div class="cartHeader">
                                <h2>Kategori <span class="fw-light fs-6">(menu berdasarkan kategori)</span></h2>
                            </div>

                            <table>
                                @foreach ($kategori as $cat)
                                <tr>
                                    <td><a href="{{route('category.menus',$cat->id)}}">{{$cat->judul }}</a></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    {{-- end category --}}
                </div>
                {{-- Menu Pagination
                                    <div class="justify-content-center d-flex">
                                           {{$menus->links("pagination::bootstrap-4")}}
            </div> --}}



        </div>
    </div>
</div>
</div>

@endsection

@section('script')
@endsection