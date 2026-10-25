<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        $items = MenuItem::orderBy('category')->orderBy('name')->paginate(20);
        return view('restaurant.menu.index', compact('items'));
    }

    public function create()
    {
        return view('restaurant.menu.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category'     => 'required|in:appetizer,main,dessert,beverage',
            'name'         => 'required|string|max:100|unique:menu_items,name',
            'description'  => 'nullable|string|max:255',
            'price'        => 'required|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        $data['is_available'] = $request->boolean('is_available', true);

        MenuItem::create($data);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(MenuItem $menu)
    {
        return view('restaurant.menu.edit', compact('menu'));
    }

    public function update(Request $request, MenuItem $menu)
    {
        $data = $request->validate([
            'category'     => 'required|in:appetizer,main,dessert,beverage',
            'name'         => 'required|string|max:100|unique:menu_items,name,' . $menu->id,
            'description'  => 'nullable|string|max:255',
            'price'        => 'required|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        $data['is_available'] = $request->boolean('is_available');
        $menu->update($data);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(MenuItem $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}