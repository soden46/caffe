<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Comment;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('authAdmin');
    }
    public function index(Request $request)
    {
        //
        if (!empty($request->search)) {
            return view('admin.orders.index')->with([
                'orders' => Transaksi::where('id', 'like', "%{$request->search}%")
                    ->orWhere('menu_name', 'like', "%{$request->search}%")
                    ->orWhere('price', 'like', "%{$request->search}%")
                    ->orWhere('total', 'like', "%{$request->search}%")
                    ->paginate(6),
                'usersCount' => User::where('admin', 0)->count(),
                'sales' => Transaksi::where('dibayar', 1)->count(),
                'ArchivedOrders' => Transaksi::whereNotNull('deleted_at')->withTrashed()->count(),
                'Earning' => Transaksi::sum('total'),
            ]);
        } else {
            return view('admin.orders.index')->with([
                'orders' => Transaksi::latest()->paginate(6),
                'usersCount' => User::where('admin', 0)->count(),
                'sales' => Transaksi::where('dibayar', 1)->count(),
                'ArchivedOrders' => Transaksi::whereNotNull('deleted_at')->withTrashed()->count(),
                'Earning' => Transaksi::sum('total'),
            ]);
        }
    }
    public function getArchive()
    {
        return view('admin.orders.index')->with([
            'orders' => Transaksi::whereNotNull('deleted_at')->withTrashed()->paginate(6),
            'usersCount' => User::where('admin', 0)->count(),
            'sales' => Transaksi::where('dibayar', 1)->count(),
            'ArchivedOrders' => Transaksi::whereNotNull('deleted_at')->withTrashed()->count(),
            'Earning' => Transaksi::sum('total'),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Transaksi  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        //
        $order = Transaksi::findOrFail($id);
        $order->update([
            'deliverde' => 1,
        ]);
        return redirect()->route('orders.index')->with(['success' => 'Delevired Status change Successfully']);
    }

    public function unarchive($id)
    {
        $order = Transaksi::where('id', $id)->withTrashed()->first();
        $order->deleted_at = null;
        $order->save();
        return redirect()->route('orders.index')->with(['success' => 'Orderd Unarchived']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $order = Transaksi::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with(['success' => 'Orderd Deleted']);
    }
}
