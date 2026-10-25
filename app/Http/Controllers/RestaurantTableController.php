<?php

namespace App\Http\Controllers;

use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class RestaurantTableController extends Controller
{
    public function index()
    {
        $tables = RestaurantTable::orderBy('area')->orderBy('table_number')->paginate(20);
        return view('restaurant.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('restaurant.tables.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'table_number' => 'required|string|max:10|unique:restaurant_tables,table_number',
            'capacity'     => 'required|integer|min:1|max:50',
            'area'         => 'required|string|max:30',
            'is_active'    => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        RestaurantTable::create($data);

        return redirect()->route('tables.index')
            ->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit(RestaurantTable $table)
    {
        return view('restaurant.tables.edit', compact('table'));
    }

    public function update(Request $request, RestaurantTable $table)
    {
        $data = $request->validate([
            'table_number' => 'required|string|max:10|unique:restaurant_tables,table_number,' . $table->id,
            'capacity'     => 'required|integer|min:1|max:50',
            'area'         => 'required|string|max:30',
            'is_active'    => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $table->update($data);

        return redirect()->route('tables.index')
            ->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy(RestaurantTable $table)
    {
        $table->delete();
        return redirect()->route('tables.index')
            ->with('success', 'Meja berhasil dihapus.');
    }
}