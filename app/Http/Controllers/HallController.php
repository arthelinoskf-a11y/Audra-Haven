<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HallController extends Controller
{
    public function index()
    {
        $halls = Hall::orderBy('name')->paginate(15);
        return view('halls.index', compact('halls'));
    }

    public function create()
    {
        return view('halls.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:100',
            'description'       => 'nullable|string',
            'capacity'          => 'required|integer|min:1',
            'size_m2'           => 'nullable|integer|min:1',
            'price_per_session' => 'required|numeric|min:0',
            'full_day_price'    => 'required|numeric|min:0',
            'is_active'         => 'boolean',
        ]);

        $data['slug']      = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);

        Hall::create($data);

        return redirect()->route('halls.index')
            ->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function edit(Hall $hall)
    {
        return view('halls.edit', compact('hall'));
    }

    public function update(Request $request, Hall $hall)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:100',
            'description'       => 'nullable|string',
            'capacity'          => 'required|integer|min:1',
            'size_m2'           => 'nullable|integer|min:1',
            'price_per_session' => 'required|numeric|min:0',
            'full_day_price'    => 'required|numeric|min:0',
            'is_active'         => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $hall->update($data);

        return redirect()->route('halls.index')
            ->with('success', 'Gedung berhasil diperbarui.');
    }

    public function destroy(Hall $hall)
    {
        $hall->delete();
        return redirect()->route('halls.index')
            ->with('success', 'Gedung berhasil dihapus.');
    }
}