<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Middleware\authAdmin;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use App\Models\Kategori;

class KategoriController extends Controller
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
            return view('admin.kategori.index')->with([
                'cats' => Kategori::where('judul', 'like', "%{$request->search}%")->paginate(10),
                'catsCount' => Kategori::count(),
                'MenusCount' => Menu::count(),
                'sales' => Transaksi::where('dibayar', 1)->count(),
                'Earning' => Transaksi::sum('total'),
            ]);
        } else {
            return view('admin.kategori.index')->with([
                'cats' => Kategori::latest()->paginate(10),
                'catsCount' => Kategori::count(),
                'MenusCount' => Menu::count(),
                'sales' => Transaksi::where('dibayar', 1)->count(),
                'Earning' => Transaksi::sum('total'),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKategoriRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKategoriRequest $request)
    {
        //
        $request->validate([
            'judul' => 'required|max:20|min:3',
            "aktif" => 'required',
        ]);
        Kategori::create([
            'judul' => $request->judul,
            'aktif' => $request->aktif,
        ]);
        return redirect()->route('kategori.index')->with(['success' => 'Category Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $Kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $kategori = Kategori::where('id', $id)->first();
        return view('admin.kategori.edit')->with(['cat' => $kategori]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKAtegoriRequest  $request
     * @param  \App\Models\KAtegori  $KAtegori
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKategoriRequest $request,/* KAtegori $KAtegori*/ $id)
    {
        //
        $request->validate([
            'judul' => 'required|min:3|max:20'
        ]);
        $Kategori = Kategori::where('id', $id)->first();
        $Kategori->update([
            'judul' => $request->judul,
            'aktif' => $request->aktif,
        ]);
        return redirect()->route('kategori.index')->with(['success' => 'Category Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KAtegori  $KAtegori
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $kategori = Kategori::where('id', $id)->first();
        $kategori->delete();
        return redirect()->route('kategoris.index')->with(['success' => 'Category Deleted']);
    }
}
