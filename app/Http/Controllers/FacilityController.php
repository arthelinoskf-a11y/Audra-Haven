<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::orderBy('category')->orderBy('name')->paginate(15);
        return view('facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('facilities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'category'     => 'required|in:tennis,gym,pool,cabana',
            'booking_type' => 'required|in:hourly_slot,session_quota,daily_quota,unit_daily',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'price_unit'   => 'required|string|max:20',
            'quota'        => 'nullable|integer|min:1',
            'open_time'    => 'required|date_format:H:i',
            'close_time'   => 'required|date_format:H:i|after:open_time',
            'is_active'    => 'boolean',
        ]);

        $data['slug']      = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);

        Facility::create($data);

        return redirect()->route('facilities.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        return view('facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'category'     => 'required|in:tennis,gym,pool,cabana',
            'booking_type' => 'required|in:hourly_slot,session_quota,daily_quota,unit_daily',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'price_unit'   => 'required|string|max:20',
            'quota'        => 'nullable|integer|min:1',
            'open_time'    => 'required|date_format:H:i',
            'close_time'   => 'required|date_format:H:i|after:open_time',
            'is_active'    => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $facility->update($data);

        return redirect()->route('facilities.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();
        return redirect()->route('facilities.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }
}