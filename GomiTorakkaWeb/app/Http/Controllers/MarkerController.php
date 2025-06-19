<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use Illuminate\Http\Request;
use App\Models\Marker;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MarkerController extends Controller
{

    public function index()
    {
        $uid = Session::get('uid');
        $role = Session::get('role');

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

        // Tambahkan URL gambar lengkap
        $markers->transform(function ($marker) {
            if ($marker->image) {
                $marker->image_url = asset(Storage::url('marker-images/' . $marker->image));
            }
            return $marker;
        });

        return response()->json($markers);
    }


    public function store(Request $request)
    {
        if (!Session::has('uid')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|string', // Pastikan validasi untuk image ada

        ]);

        $marker = new Marker();
        $marker->uid = Session::get('uid');
        $marker->latitude = $request->latitude;
        $marker->longitude = $request->longitude;
        $marker->description = $request->description ?? 'Tempat Sampah';
        $marker->status = 'pending';
        $marker->image = $request->image; // Simpan nama file gambar
        $marker->save();

        return response()->json([
            'message' => 'Marker berhasil dikirim untuk ditinjau admin',
            'marker_id' => $marker->marker_id,
            'latitude' => $marker->latitude,
            'longitude' => $marker->longitude,
            'description' => $marker->description,
            'status' => $marker->status,
            'image' => $marker->image
        ], 201);
    }

    public function uploadImage(Request $request)
    {
        if (!Session::has('uid')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();

            // Simpan ke storage/app/public/marker-images
            $image->storeAs('marker-images', $imageName, 'public');

            return response()->json([
                'success' => true,
                'filename' => $imageName,
                'path' => asset(Storage::url('marker-images/' . $imageName))
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage()
            ], 500);
        }
    }


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


        $message = $request->status === 'approved'
            ? 'Your Request Has Been Approved By Admin.'
            : 'Your Request Is Rejected By Admin.';

        if (!empty($request->admin_note)) {
            $message .= ' Catatan: ' . $request->admin_note;
        }


        Inbox::create([
            'user_id' => $marker->uid,
            'marker_id' => $marker->marker_id,
            'title' => 'Status Request Marker',
            'message' => $message,
            'status' => 'unread',
        ]);


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
