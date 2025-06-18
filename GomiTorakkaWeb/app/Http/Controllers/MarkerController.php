<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
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
            $markers = Marker::orderBy('created_at', 'desc')->get();
        } else {
            $markers = Marker::where(function ($query) use ($uid) {
                $query->where('status', 'approved')
                    ->orWhere(function ($q) use ($uid) {
                        $q->where('status', 'pending')
                            ->where('uid', $uid);
                    });
            })->orderBy('created_at', 'desc')->get();
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

        // Buat pesan
        $message = $request->status === 'approved'
            ? 'Your Request Has Been Approved By Admin.'
            : 'Your Request Is Rejected By Admin.';

        if (!empty($request->admin_note)) {
            $message .= ' Catatan: ' . $request->admin_note;
        }

        // Kirim ke inbox
        Inbox::create([
            'user_id' => $marker->uid,
            'marker_id' => $marker->marker_id,
            'title' => 'Status Permintaan Marker',
            'message' => $message,
            'status' => 'unread',
        ]);

        // ❗️Hapus marker jika status = rejected
        if ($request->status === 'rejected') {
            $marker->delete();
        }

        return response()->json(['message' => 'Status marker diperbarui dan pesan dikirim ke inbox']);
    }



    public function requestPanel()
    {
        $role = Session::get('role');
        $uid = Session::get('uid');

        if ($role === 'admin') {
            $markers = Marker::orderBy('created_at', 'desc')->get();
        } else {
            $markers = Marker::where('uid', $uid)->orderBy('created_at', 'desc')->get();
        }

        return view('RequestPanel', compact('markers'));
    }
}
