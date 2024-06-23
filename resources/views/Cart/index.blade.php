@extends('layout.app')

@section('content')
    <!-- cart item -->
    <div class="small-container cart-page mb-4">
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>
                            <div class="cart-info">
                                <img src="{{ asset('images/menu/' . $item->attributes->foto) }}" alt="{{ $item->name }}">
                                <div>
                                    <p>{{ $item->name }}</p>
                                    <small>Harga: Rp. {{ number_format($item->price, 2) }}</small>
                                    <br>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" id="removeItemForm">
                                        @csrf
                                        @method("DELETE")
                                        <button class="removeBtn" type="submit">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="number"
                                       name="quantity"
                                       id="quantity"
                                       value="{{ $item->quantity }}"
                                       min="1"
                                       max="{{ $item->attributes->quantity }}"
                                       class="form-control">
                                <button type="submit" class="btn btn-sm btn-warning mt-2">
                                    <i class="fas fa-edit"></i> Update
                                </button>
                            </form>
                        </td>
                        <td class="price">Rp. {{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (Cart::getSubTotal() > 0)
            <div class="total-price mt-4">
                <table>
                    <tr>
                        <td>SubTotal</td>
                        <td class="fw-bolder">Rp. {{ number_format(Cart::getSubTotal(), 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            @if (Cart::getSubTotal() > 0)
                                <div class="row">
                                    <div class="form-group">
                                        <a href="{{ route('make.payment') }}" class="btn-paypal mt-3 ml-2 d-flex align-items-center">
                                            <i class="fab fa-cc-paypal mr-1" style="font-size: 1.7rem"></i>
                                            Bayar Rp. {{ number_format(Cart::getSubTotal(), 2) }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        @endif
        </div>
    </div>
@endsection
