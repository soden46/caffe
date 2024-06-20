<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\Kategori;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreMenuRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateMenuRequest;

class MenuController extends Controller
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
            return view('admin.Menu.index')->with([
                'menus' => Menu::where('judul', 'like', "%{$request->search}%")->orWhere('id', 'like', "%{$request->search}%")->orWhere('deskripsi', 'like', "%{$request->search}%")->paginate(6),
                'kategori' => Kategori::all(),
                'kategoriCount' => Kategori::count(),
                'MenusCount' => Menu::count(),
                'PROMOMenusCount' => Menu::where('promo', 1)->count(),
                'Earning' => Transaksi::sum('total'),
            ]);
        } else {
            return view('admin.Menu.index')->with([
                'menus' => Menu::latest()->paginate(6),
                'kategori' => Kategori::all(),
                'kategoriCount' => Kategori::count(),
                'MenusCount' => Menu::count(),
                'PROMOMenusCount' => Menu::where('promo', 1)->count(),
                'Earning' => Transaksi::sum('total'),
            ]);
        }
    }


    public function getMenuByCategory($id)
    {
        $category = Kategori::where('id', $id)->first();
        return view('admin.Menu.index')->with([
            'menus' => $category->Menus()->latest()->paginate(6),
            'kategori' => Kategori::all(),
            'kategoriCount' => Kategori::count(),
            'MenusCount' => Menu::count(),
            'PromoMenusCount' => Menu::where('promo', 1)->count(),
            'Earning' => Transaksi::sum('total'),
        ]);
    }
    public function PROMO($id)
    {
        $menu = Menu::where('id', $id)->first();
        $menu->promo = 1;
        $menu->save();
        return redirect()->route('Menu.index')->with(['success' => 'Menu Added to PROMO Menus ']);
        # code...
    }

    public function NONPROMO($id)
    {
        $menu = Menu::where('id', $id)->first();
        $menu->promo = 0;
        $menu->save();
        return redirect()->route('Menu.index')->with(['success' => 'Menu Removed From PROMO Menus ']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.Menu.create')->with(['kategori' => Kategori::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {
        //
        $request->validate([
            'judul' => 'required|min:3|max:20',
            'deskripsi' => 'required|min:5',
            'harga' => 'numeric|Nullable',
            'harga_lama' => 'numeric|Nullable',
            'foto' => 'required|image|mimes:png,jpg,jpeg|max:7000',
            'id_kategori' => 'required|numeric',
        ]);
        if ($request->has('foto')) {
            $file = $request->foto;
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/menu'), $imageName);
        }
        if ($request->harga === "" && $request->harga_lama === "") {
            $request->harga = 0;
            $request->harga_lama = 0;
        } elseif ($request->harga === "") {
            $request->harga = 0;
        } elseif ($request->old_price == "") {
            $request->harga_lama = 0;
        }
        Menu::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'harga_lama' => $request->harga_lama,
            'foto' => $imageName,
            'id_kategori' => $request->id_kategori,
        ]);
        return redirect()->route('Menu.index')->with(['success' => 'menu Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $menu = Menu::where('id', $id)->first();
        // dd($menu);
        return view('admin.Menu.edit')->with([
            'menu' => $menu,
            "kategori" => Kategori::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, $id)
    {
        //

        $menu = Menu::where('id', $id)->first();
        $request->validate([
            'judul' => 'nullable|min:3|max:20',
            'deskripsi' => 'nullable|min:5',
            'harga' => 'numeric|Nullable',
            'harga_lama' => 'numeric|Nullable',
            'foto' => 'image|mimes:png,jpg,jpeg|max:7000',
            'id_kategori' => 'nullable',
        ]);
        if ($request->has('foto')) {
            $image_path = public_path("images/menu/" . $menu->foto);
            if (File::exists($image_path)) {
                unlink($image_path);
            }
            $file = $request->foto;
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/menu'), $imageName);
            $menu->foto = $imageName;
        }
        if ($request->harga === "" && $request->harga_lama === "") {
            $request->harga = 0;
            $request->harga_lama = 0;
        } elseif ($request->pric === "") {
            $request->harga = 0;
        } elseif ($request->harga_lama == "") {
            $request->harga_lama = 0;
        }
        $menu->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'harga_lama' => $request->harga_lama,
            'foto' => $menu->foto,
            'id_kategori' => $request->id_kategori,
        ]);
        return redirect()->route('Menu.index')->with(['success' => 'menu updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('Menu.index')->with(['sucess' => 'Menu Deleted']);
    }
}
