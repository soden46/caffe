<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Komen;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Query\OrExpr;

class AdminController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('authAdmin');
    }
    public function index()
    {
        $orders = Transaksi::all();
        return view('admin.index')->with([
            'usersCount' => User::where('admin', 0)->count(),
            'Penjualan' => Transaksi::where('dibayar', 1)->count(),
            'Penilaian' => Komen::where('status', 1)->count(),
            'Pendapatan' => Transaksi::sum('total'),
            // sum total group by menu
            'SalesByMenus' => Transaksi::select(DB::raw('sum(total) as total_quantity'), 'nama_menu')
                ->groupBy('nama_menu')->get(),
            // hadi kanjib biha chhal mn order dar fkola chhr
            'OrdersCountByDate' => Transaksi::select(
                DB::raw('count(id) as CountOrder'),
                DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as month_year")
            )
                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))->get(),
        ]);
    }
}
