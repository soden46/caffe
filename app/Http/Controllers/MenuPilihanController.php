<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoremenuPilihanRequest;
use App\Http\Requests\UpdatemenuPilihanRequest;
use App\Models\MenuPilihan;

class MenuPilihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('MenuPilihan.index')->with([
            'MenuPilihan' => MenuPilihan::where('user_id', auth()->user()->id)->get(),
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
     * @param  \App\Http\Requests\StoremenuPilihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoremenuPilihanRequest $request)
    {


        $request->validate([
            'id_user' => 'required|numeric',
            'id_menu' => 'required|numeric',
        ]);
        MenuPilihan::create([
            'id_user' => $request->id_user,
            'id_menu' => $request->id_menu,

        ]);
        return redirect()->route('resto.index')->with(['success' => 'Menu Berhasil ditambahkan ke Pilihan Favorit']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\menuPilihan  $menuPilihan
     * @return \Illuminate\Http\Response
     */
    public function show(menuPilihan $menuPilihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\menuPilihan  $menuPilihan
     * @return \Illuminate\Http\Response
     */
    public function edit(menuPilihan $menuPilihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatemenuPilihanRequest  $request
     * @param  \App\Models\menuPilihan  $menuPilihan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatemenuPilihanRequest $request, menuPilihan $menuPilihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\menuPilihan  $menuPilihan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $menuPilihan = menuPilihan::findOrFail($id);
        $menuPilihan->delete();
        return redirect()->route('pilihan.index')->with(['success' => 'Menu Berhasil dihapus ke Pilihan Favorit']);
    }
}
