<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marker;
use Illuminate\Support\Facades\Session;

class MarkerController extends Controller
{
    // ✅ Tampilkan semua marker sesuai role
    public function index()
    {
        $uid = Session::get('uid');
        $role = Session::get('role'); // pastikan kamu simpan 'role' saat login

        if ($role === 'admin') {
            $markers = Marker::all();
        } else {
            $markers = Marker::where(function ($query) use ($uid) {
                $query->where('status', 'approved')
                      ->orWhere(function ($q) use ($uid) {
                          $q->where('status', 'pending')
                            ->where('uid', $uid);
                      });
            })->get();
        }

        return response()->json($markers);
    }

    // ✅ Simpan marker baru
    public function store(Request $request)
    {
        // Pastikan user login
        if (!Session::has('uid')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $marker = new Marker();
        $marker->uid = Session::get('uid');
        $marker->latitude = $request->latitude;
        $marker->longitude = $request->longitude;
        $marker->description = $request->description ?? 'Tempat Sampah';
        $marker->status = 'pending'; // default pending
        $marker->save();

        return response()->json([
            'message' => 'Marker berhasil dikirim untuk ditinjau admin',
            'id' => $marker->marker_id
        ], 201);
    }

    // ✅ Fungsi hanya untuk admin: Approve atau Reject marker
    public function updateStatus(Request $request, $id)
    {
        $role = Session::get('role');
        if ($role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string'
        ]);

        $marker = Marker::findOrFail($id);
        $marker->status = $request->status;
        $marker->admin_note = $request->admin_note;
        $marker->save();

        return response()->json(['message' => 'Status marker diperbarui']);
    }
}
