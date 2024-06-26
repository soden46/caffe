@extends('layout.app')

@section('content')
    <!-- cart item -->
    <div class="small-container cart-page mb-4">
    <form action="{{ route('payment.checkout') }}" method="POST">
        @csrf
        <input type="text" name="first_name" placeholder="First Name">
        <input type="text" name="last_name" placeholder="Last Name">
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="phone" placeholder="Phone">
        <input type="number" name="amount" placeholder="Amount">
        <button type="submit">Bayar Sekarang</button>
    </form>
    </div>
@endsection