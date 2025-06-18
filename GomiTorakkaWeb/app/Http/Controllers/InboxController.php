<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inbox;
use Illuminate\Support\Facades\Session;

class InboxController extends Controller
{
    // Tampilkan semua inbox untuk user berdasarkan uid
    public function index($uid)
    {
        $sessionUid = session('uid');

        // Pastikan user hanya melihat inbox miliknya sendiri
        if ($uid != $sessionUid) {
            abort(403, 'Akses tidak diizinkan');
        }

        $inboxes = \App\Models\Inbox::where('user_id', $uid)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('inbox.index', compact('inboxes'));
    }


    // Tandai pesan sebagai telah dibaca
    public function markAsRead($id)
    {
        $inbox = Inbox::find($id);
        if ($inbox && $inbox->status === 'unread') {
            $inbox->status = 'read';
            $inbox->save();
        }

        return redirect()->back()->with('success', 'Pesan ditandai sebagai dibaca.');
    }

    public function getInbox()
    {
        if (!Session::has('uid')) {
            return response()->json([], 401); // Unauthorized
        }

        $userId = Session::get('uid');
        $inbox = \App\Models\Inbox::where('user_id', $userId)->where('status', 'unread')->get();

        return response()->json($inbox);
    }

}
