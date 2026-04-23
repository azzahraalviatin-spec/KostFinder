<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Keluhan;
use Illuminate\Http\Request;

class KeluhanController extends Controller
{
    public function index()
    {
        $keluhans = Keluhan::with('booking.room.kost')
                        ->latest()
                        ->get();

        return view('owner.keluhan.index', compact('keluhans'));
    }

    public function show($id)
    {
        $keluhan = Keluhan::with('booking.room.kost')
                        ->findOrFail($id);

        return view('owner.keluhan.show', compact('keluhan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $keluhan = Keluhan::findOrFail($id);
        $keluhan->status = $request->status;
        $keluhan->save();

        return back()->with('success', 'Status berhasil diupdate');
    }
}