<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Tampilkan daftar kamar
    public function index()
    {
        $rooms = Room::with('roomType')->orderBy('room_number')->paginate(15);
        return view('rooms.index', compact('rooms'));
    }

    // Form tambah kamar
    public function create()
    {
        $roomTypes = RoomType::where('is_active', 1)->orderBy('name')->get();
        return view('rooms.create', compact('roomTypes'));
    }

    // Simpan kamar baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number'  => 'required|string|max:10|unique:rooms,room_number',
            'floor'        => 'required|integer|min:1|max:50',
            'status'       => 'required|in:available,occupied,cleaning,maintenance',
        ]);

        Room::create($data);

        return redirect()->route('rooms.index')
            ->with('success', 'Kamar berhasil ditambahkan.');
    }

    // Form edit
    public function edit(Room $room)
    {
        $roomTypes = RoomType::where('is_active', 1)->orderBy('name')->get();
        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    // Simpan perubahan
    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number'  => 'required|string|max:10|unique:rooms,room_number,' . $room->id,
            'floor'        => 'required|integer|min:1|max:50',
            'status'       => 'required|in:available,occupied,cleaning,maintenance',
        ]);

        $room->update($data);

        return redirect()->route('rooms.index')
            ->with('success', 'Kamar berhasil diperbarui.');
    }

    // Hapus
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')
            ->with('success', 'Kamar berhasil dihapus.');
    }
}