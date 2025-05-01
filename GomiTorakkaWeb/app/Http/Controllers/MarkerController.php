<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marker;

class MarkerController extends Controller
{
    public function index()
    {
        return response()->json(Marker::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $marker = new Marker();
        $marker->user_id = auth()->check() ? auth()->id() : null;
        $marker->latitude = $request->latitude;
        $marker->longitude = $request->longitude;
        $marker->description = $request->description ?? 'Tempat Sampah';
        $marker->status = $request->status ?? 'aktif';
        $marker->save();

        return response()->json(['message' => 'Marker berhasil disimpan', 'id' => $marker->marker_id], 201);
    }
}

