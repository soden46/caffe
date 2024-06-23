
@extends('layout.app')

@section('content')
    <!-- cart item -->
    <div class="small-container cart-page mb-4">
        <table>
            <tr>
                <th>Menu</th>
                <th>total</th>
            </tr>

                @foreach ($MenuPilihan as $item)
                     <tr>
                        <td>
                            <div class="cart-info">
                                <img src="{{asset('images/menu/'.$item->Menu->foto)}}" alt="">
                                <div>
                                    <h3>{{$item->Menu->judul}}</h3>
                                    <small>{{$item->Menu->deskripsi}}</small>
                                    </br>
                                        {{-- remove menu from cart form --}}
                                        <form action="{{route('pilihan.destroy',$item->id)}}"
                                                    method="POST"
                                                    id="removeItemform">
                                            @csrf
                                            @method("DELETE")
                                            <button class="removeBtn" type="submit">Remove</button>
                                        </form>
                                </div>
                            </div>
                        </td>
                        <td class="price">Harga : Rp. {{$item->Menu->harga}}</td>


                    </tr>
                @endforeach
        </table>


    </div>
@endsection
