<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
         if (auth()->check()&& auth()->user()->role === 'user') {
            // Jika pengguna sudah login, tampilkan halaman yang sesuai
            $menus = Menu::all();
            return view('welcome', compact('menus'));
        } else {
            // Jika pengguna belum login, arahkan ke halaman yang sesuai
            $menus = Menu::all();
            return view('cartp', compact('menus'));
        }

    }
    public function guest()
    {
        $menus = Menu::all();
        return view('cartp', compact('menus'));
    }

    public function kasir()
{
    // Periksa apakah pengguna memiliki peran 'kasir' atau 'admin'
    if (auth()->check() && auth()->user()->role === 'kasir') {
        // Jika pengguna memiliki peran 'kasir', tampilkan data menu
        $menus = Menu::all();
        return view('cart', compact('menus'));
    } elseif (auth()->check() && auth()->user()->role === 'admin') {
        // Jika pengguna memiliki peran 'admin', redirect ke halaman transaksi
        return redirect()->route('transactions');
    } else {
        // Jika pengguna tidak memiliki peran yang sesuai, kembalikan ke halaman beranda atau tampilkan pesan kesalahan
        return redirect()->route('home.index')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
     public function checkout (Request $request)
    {
        // Retrieve cart items from the query parameters
        $cartItems = $request->query('cartItems');

        // Pass the cart items to the checkout view
        return view('checkout', ['cartItems' => $cartItems]);

    }

    public function histori()
    {
    $data = Transaction::where('user_id', auth()->user()->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
    return view('histori', compact('data'));
    }

}