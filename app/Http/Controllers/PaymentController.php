<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Transaksi;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
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

        $total = Cart::session($userId)->getContent();
        $invoiceId = 'INV-' . uniqid();
        $invoiceDate = now();
        $user = User::find($userId);

        return view('payment.checkout', compact('items', 'total', 'user', 'invoiceId', 'invoiceDate'));
    }

    public function confirm(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'id_user' => 'required', // Pastikan id_user ada di tabel users
            'nama_menu' => 'required',
            'qty' => 'required',
            'harga' => 'required',
            'total' => 'required',
            'dibayar' => 'required',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Menangani upload file bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
        }

        // Membuat data transaksi
        Transaksi::create([
            'id_user' => $request->id_user,
            'nama_menu' => $request->nama_menu, // Sesuaikan dengan nama field di form
            'qty' => $request->qty,
            'harga' => $request->harga,
            'total' => $request->total,
            'dibayar' => $request->dibayar,
            'bukti_pembayaran' => $filename, // Menyimpan nama file bukti pembayaran jika ada
        ]);

        return redirect()->route('user.transactions')->with('success', 'Bukti pembayaran berhasil diunggah.');
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

    public function showTransactions()
    {
        $transactions = Transaksi::where('id_user', auth()->id())->get();

        return view('transactions.index', compact('transactions'));
    }

    public function invoice($id)
    {
        // Ambil data transaksi
        $order = Transaksi::findOrFail($id);

        // Data untuk view
        $data = [
            'title' => 'Invoice',
            'order' => $order,
        ];

        // Pengaturan kertas khusus
        $customPaper = [0, 0, 567.00, 500.80];

        // Generate PDF dengan view dan pengaturan kertas
        $pdf = PDF::loadView('transactions.invoice', $data)
            ->setPaper($customPaper, 'portrait');

        // Unduh file PDF
        return $pdf->download('invoice_' . $order->id . '.pdf');
    }
}
