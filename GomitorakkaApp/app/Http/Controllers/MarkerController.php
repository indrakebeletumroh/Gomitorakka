<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marker;

class MarkerController extends Controller
{
    public function store(Request $request)
    {
        $marker = new Marker();
        $marker->lat = $request->lat;
        $marker->lng = $request->lng;
        $marker->jenis = $request->jenis;
        $marker->save();

        return response()->json(['status' => 'success', 'message' => 'Marker ditambahkan']);
    }
}
