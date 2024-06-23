@extends('layout.app')

@section('content')
{{-- Index page content  --}}

<!--- Home Section Start ---->
<section class="home" id="home">

    <div class="swiper home-slider">
        <div class="swiper-wrapper wrapper">
            <div class="swiper-slide slide">
                <div class="content">
                   <span>Menu Paket Kami</span>
                    <h3>Paket Siang A</h3>
                    <p>2 Jam + 1 Softdrink Rp. 40.000</p>
                    <a href="#" class="btn">order now</a>
                </div>
                <div class="image">
                    <img src="{{asset('images/osaka.jpg')}}" alt="" >
                </div>
            </div>

            <div class="swiper-slide slide">
                <div class="content">
                    <span>Menu Paket Kami</span>
                    <h3>Paket Siang B</h3>
                    <p>3 Jam + 2 Softdrink Rp. 60.000</p>
                    <a href="#" class="btn">order now</a>
                </div>
                <div class="image">
                    <img src="{{asset('images/osaka.jpg')}}" alt="" >
                </div>
            </div>

            <div class="swiper-slide slide">
                <div class="content">
                    <span>Menu Paket Kami</span>
                    <h3>Paket Malam A</h3>
                    <p>2 Jam + 1 Softdrink Rp. 65.000</p>
                    <a href="#" class="btn">order now</a>
                </div>
                <div class="image">
                    <img src="{{asset('images/osaka.jpg')}}" alt="" >
                </div>
            </div>

            <div class="swiper-slide slide">
                <div class="content">
                    <span>Menu Paket Kami</span>
                    <h3>Paket Malam B</h3>
                    <p>3 Jam + 2 Softdrink Rp. 95.000</p>
                    <a href="#" class="btn">order now</a>
                </div>
                <div class="image">
                    <img src="{{asset('images/osaka.jpg')}}" alt="" >
                </div>
            </div>
        </div>

        <div class="swiper-pagination"></div>

    </div>
</section>


<!--- Home Section End --->

@if ($promo !== 0)
<!-- Dish section Strat  --->
<section class="dishes" id="dishes">
    <h3 class="sub-heading">Promo</h3>
    <h1 class="heading">Menu Promo</h1>
    <div class="box-container">
        @foreach ($promo as $menupromo)
        <div class="box">
            <form action="{{route('pilihan.store')}}" method="POST">
                @csrf
                @if (auth()->user())
                <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                <input type="hidden" name="menu_id" value="{{$menupromo->id}}">
                @endif
                <button type="submit"> <i class="fas fa-heart"></i></button>
                {{--<a href="#" class="fas fa-eye"></a>--}}
            </form>
            <img src="{{asset('images/menu/'.$menupromo->foto)}}" alt="">
            <h3>{{$menupromo->judul}}</h3>

            <span>RP {{$menupromo->harga}}</span>
            <form action="{{route('cart.add',$menupromo->id)}}" method="POST">

                <input type="hidden" name="quantity" value="1">
                @csrf
                <button type="submit" class="btn">tambah ke keranjang</button>
            </form>

        </div>
        @endforeach
    </div>
</section>
<!-- Dish section End  --->
@endif


<!-- About Section Start -->
<section class="about" id="about">
    <h3 class="sub-heading">Tentang Kami</h3>
    <h1 class="heading">Kenapa Memilih Kami?</h1>
    <div class="row">
        <div class="image">
            <img src="{{asset('images/osaka.jpg')}}" alt="" >
        </div>
        <div class="content">
            <h3>Osaka Billiard Dan Cafe Yogyakarta</h3>
            <p>- Meja Billiard Menggunakan meja billiard dengan ukuran standar internasional, Meja terbuat dari bahan berkualitas tinggi dengan permukaan yang rata dan bantalan yang sesuai untuk pantulan bola yang akurat.
            </br>- Peralatan Bola billiard dan stick (cue) yang digunakan harus memenuhi standar internasional dalam hal ukuran, berat, dan bahan. Bola billiard  berkualitas tinggi yang memberikan ketahanan dan performa yang optimal.
            </br>- Pencahayaan: Pencahayaan yang memadai dan seragam di seluruh meja untuk menghindari bayangan dan memastikan pemain dapat melihat bola dengan jelas. Lampu dipasang pada ketinggian tertentu untuk memberikan pencahayaan yang ideal.
            </br>- Lantai dan Lingkungan, Lantai terbuat dari bahan yang tahan lama dan tidak licin, seperti karpet . Suasana ruangannya nyaman, dengan ventilasi yang baik dan suhu yang terkontrol.
            </br>- Perawatan, Meja dan peralatan billiard harus dirawat secara rutin untuk menjaga kualitas dan performanya. Ini termasuk perawatan kain meja, pengecekan dan penggantian bantalan, serta pembersihan bola dan stick.
            </br>- Fasilitas Tambahan, dilengkapi dengan fasilitas tambahan seperti bar atau kafe, ruang tunggu yang nyaman, toilet yang bersih.
            </br>- Aksesibilitas, Lokasinya mudah diakses dengan fasilitas parkir yang memadai dan ramah.</p>
            
            <div class="icons-container">
                <div class="icons">
                    <i class="fas fa-shipping-fast"></i>
                    <span>gratis pengantaran</span>
                </div>
                <div class="icons">
                    <i class="fas fa-dollar-sign"></i>
                    <span>pembayaran mudah</span>
                </div>
                <div class="icons">
                    <i class="fas fa-headset"></i>
                    <span>Reservasi</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section End -->



<!-- menu Section start-->

<section class="menu" id="menu">
    <h3 class="sub-heading">Daftar Menu</h3>
    <h1 class="heading">Menu Kami</h1>
    <div class="box-container">
        @foreach ($menu as $menu)
        <div class="box">
            <div class="image">
                <img src="{{asset('images/menu/'.$menu->foto)}}" alt="">
                <form action="{{route('pilihan.store')}}" method="POST">
                    @csrf
                    @if (auth()->user())
                    <input type="hidden" name="id_user" value="{{auth()->user()->id}}">
                    <input type="hidden" name="id_menu" value="{{$menu->id}}">
                    @endif
                    <button type="submit"> <i class="fas fa-heart"></i></button>
                </form>
            </div>
            <div class="content">

                <h3>{{$menu->judul}}</h3>
                <p>
                    {{$menu->deskripsi}}
                </p>
                <span class="price">Rp {{$menu->harga}}</span>
                <form action="{{route('cart.add',$menu->id)}}" method="POST">
                    {{-- nsift qte =1 f index  cart --}}
                    <input type="hidden" name="quantity" value="1">
                    @csrf
                    <button type="submit" class="btn">add to cart</button>
                </form>

            </div>
        </div>
        @endforeach


    </div>
</section>

<!-- menu section end -->

<!-- review section start -->
@if ($reviews->count())
<section class="review" id="review">
    <h3 class="sub-heading">Penilaian Pelanggan</h3>
    <h1 class="heading"></h1>
    <div class="swiper-container review-slider ">
        <div class="swiper-wrapper">

            @foreach ($reviews as $review)
            @if ($review->status)
            <div class="swiper-slide slide">
                <i class="fas fa-quote-right"></i>
                <div class="userrev">
                    @if ($review->user->image === 'image')
                    <img src="{{asset('images/profile/userImage.png')}}" alt="user-image">
                    @else
                    <img src="{{asset('images/profile/'.$review->user->image)}}" alt="user-image">
                    @endif

                    <div class="user-info">
                        <h3>{{$review->user->name}}</h3>
                    </div>

                </div>
                <p>
                    {{$review->comment}}
                </p>
            </div>
            @endif

            @endforeach
        </div>
    </div>
</section>
@endif
<!-- review section end -->

<!-- Ordre Section start -->
<div class="review2" id="review2">
    <h3 class="sub-heading">Penilaian</h3>
    <h1 class="heading">Tambah Penilaian Anda</h1>
    <form action="{{route('reviews.store')}}" method="POST">
        @csrf
        <div class="inputBox">
            <div class="input">
                <span>Penilaian Anda</span>
                <textarea name="comment" placeholder="entre your review" id="" cols="30" rows="10"></textarea>
            </div>
        </div>

        <input type="submit" value="add your review" class="btn">
    </form>
</div>

<!-- Ordre Section end --->
@endsection