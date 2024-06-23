<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $cartContent = Cart::session($userId)->getContent();

        return view('cart.index')->with([
            'items' => $cartContent,
            'itemsCount' => $cartContent->count(), // qte
        ]);
    }

    public function addMenuToCart(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $userId = auth()->user()->id;

        Cart::session($userId)->add(array(
            'id' => $menu->id,
            'name' => $menu->judul, // Jika field judul di database adalah 'judul'
            'price' => $menu->harga, // Jika field harga di database adalah 'harga'
            "quantity" => $request->quantity ? $request->quantity : 1, // Jika quantity tidak ada, default 1
            "attributes" => array(
                'foto' => $menu->foto,
                'deskripsi' => $menu->deskripsi,
                'harga_lama' => $menu->harga_lama,
                'id_kategori' => $menu->id_kategori,
            ),
            "associatedModel" => $menu,
        ));

        return redirect()->route('cart.index');
    }

    // update item in cart function
    public function updateItemInCart($id, Request $request)
    {
        $userId = auth()->user()->id;

        Cart::session($userId)->update($id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity,
            ),
        ));

        return redirect()->route('cart.index');
    }

    // remove item from cart function
    public function removeItemFromCart($id)
    {
        $userId = auth()->user()->id;

        Cart::session($userId)->remove($id);

        return redirect()->route('cart.index');
    }
}
