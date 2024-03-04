<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->role === 'admin'){
        $menus = Menu::paginate(10);
        return view('menus.index', compact('menus'));
        }elseif (auth()->check() && auth()->user()->role === 'user') {
            return redirect()->route('home.index');
        }elseif (auth()->check() && auth()->user()->role === 'kasir') {
            return redirect()->route('home.kasir');
        }
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_menu' => 'required',
        'gambar_menu' => 'required', // Ensure it's an image file
        'harga' => 'required',
        'kategori' => 'required'
    ]);

     $gambar_menu_path = '';
    // Store the image
    if ($request->hasFile('gambar_menu')) {
        $gambar_menu = $request->file('gambar_menu');
        $gambar_menu_path = $gambar_menu->store('menu_photos','public'); // Store the image in storage
        $gambar_menu_path = str_replace('public/', 'storage/', $gambar_menu_path); // Update the path to make it accessible
    }

    // Create a new menu instance
    $menu = new Menu;
    $menu->nama_menu = $request->nama_menu;
    $menu->gambar_menu = $gambar_menu_path; // Save the image path
    $menu->harga = $request->harga;
    $menu->kategori = $request->kategori;
    $menu->save();

    return redirect()->route('menus.index')->with('success', 'Menu created successfully.');
}
    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, $id)
{
    $menu = Menu::findOrFail($id);

    // Update other fields
    $menu->nama_menu = $request->input('nama_menu');
    $menu->harga = $request->input('harga');
    $menu->kategori = $request->input('kategori');

    // Handle image upload
    if ($request->hasFile('gambar_menu')) {
        $gambar_menu = $request->file('gambar_menu');
        $gambarMenuPath = $gambar_menu->store('menu_photos','public');;
        $gambarMenuPath = str_replace('public/', 'storage/', $gambarMenuPath);
        $menu->gambar_menu = $gambarMenuPath;
    }

    $menu->save();

    return redirect()->route('menus.index')->with('success', 'Menu updated successfully.');
}

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menus.index')
                         ->with('success', 'Menu deleted successfully');
    }
}