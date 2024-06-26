<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Transaksi;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function handelPayment()
    {
        $userId = auth()->user()->id;

        $items = [];

        foreach (Cart::session($userId)->getContent() as $item) {
            array_push($items, [
                'id' => $item->id,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'name' => $item->name
            ]);
        }

        $orderId = uniqid();
        $total = Cart::session($userId)->getTotal();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => auth()->user()->nama,
                'email' => auth()->user()->email,
            ],
        ];
        $snapToken = Snap::getSnapToken($params);

        return view('payment.checkout', compact('snapToken'));
    }

    public function CancelPayment()
    {
        return redirect()->route('cart.index')->with([
            'info' => "You have declined the payment.",
        ]);
    }

    public function SuccessPayment(Request $request)
    {
        $userId = auth()->user()->id;
        foreach (Cart::session($userId)->getContent() as $item) {
            Transaksi::create([
                "id_user" => auth()->user()->id,
                "nama_menu" => $item->name,
                "qty" => $item->quantity,
                "harga" => $item->price,
                "total" => $item->price * $item->quantity,
                "dibayar" => 1, //paid successfully
                'diantar' => 0,
            ]);
        }
        Cart::session($userId)->clear();

        return redirect()->route('resto.index')->with([
            'success' => 'Payment has been made successfully.'
        ]);
    }

    public function handleNotification(Request $request)
    {
        $notification = new \Midtrans\Notification();

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // Transaction is challenged
                } else {
                    // Transaction is success
                }
            }
        } else if ($transaction == 'settlement') {
            // Transaction is success
        } else if ($transaction == 'pending') {
            // Transaction is pending
        } else if ($transaction == 'deny') {
            // Transaction is denied
        } else if ($transaction == 'expire') {
            // Transaction is expired
        } else if ($transaction == 'cancel') {
            // Transaction is canceled
        }
    }
}
