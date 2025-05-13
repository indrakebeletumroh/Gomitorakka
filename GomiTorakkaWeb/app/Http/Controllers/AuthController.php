<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image; 

class AuthController extends Controller
{
    function form_register(){
        return view('register');
    }

    function submit(Request $request){
        $users = new users();
        $users->age = $request->age;
        $users->username = $request->username;
        $users->phone_number = $request->phone_number;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        
        $users->save();

        return redirect()->route('form_login.tampil');
    }

    function form_login() {
        return view('login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = users::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Simpan semua data yang diperlukan ke session
            Session::put([
                'uid' => $user->uid,
                'age' => $user->age,
                'username' => $user->username,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'profile_picture' => $user->profile_picture,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'role' => $user->role, // <-- TAMBAHKAN INI
                'logged_in' => true
            ]);

            return redirect()->route('profile');
        } else {
            return back()->withErrors([
                'login' => 'Username atau password salah.',
            ]);
        }
    }


    // Tambahkan method untuk profile page
    public function profile()
    {
        // Cek apakah user sudah login
        if (!Session::has('logged_in')) {
            return redirect()->route('form_login.tampil');
        }

        // Ambil data dari session
        $userData = [
            'username' => Session::get('username'),
            'email' => Session::get('email'),
            'phone_number' => Session::get('phone_number')
        ];

        return view('profile', ['user' => $userData]);
    }

    // Tambahkan method untuk logout
    public function logout()
    {
        // Hapus semua session
        Session::flush();
        
        return redirect('/');
    }

    public function update(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'age' => 'required|integer|min:12|max:120',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:8',
        'cropped_image' => 'nullable|string',
    ]);

   $user = users::where('uid', Session::get('uid'))->firstOrFail();

    
  if ($request->cropped_image) {
    $imageData = $request->cropped_image;
    list($type, $imageData) = explode(';', $imageData);
    list(, $imageData) = explode(',', $imageData);
    $data = base64_decode($imageData);

    $fileName = 'profile_'.Session::get('uid').'_'.time().'.jpg';
    $user->profile_picture = 'profiles/'.$fileName;
  
    $path = "profiles/{$fileName}";
    

    if (!Storage::disk('public')->exists('profiles')) {
        Storage::disk('public')->makeDirectory('profiles');
    }

    Storage::disk('public')->put($path, $data);
    $path = "profiles/{$fileName}";
    
    // Store using Laravel's filesystem
    Storage::disk('public')->put($path, $data);
    
    // Store relative path without 'storage/' prefix
    $user->profile_picture = $path; 
}

    // Update user data
    $user->username = $request->username;
    $user->age = $request->age;
    $user->phone_number = $request->phone;
    $user->email = $request->email;
    
    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    // Update session data
    Session::put([
        'username' => $user->username,
        'age' => $user->age,
        'email' => $user->email,
        'phone_number' => $user->phone_number,
        'updated_at' => $user->updated_at,
        'profile_picture' => $user->profile_picture
    ]);

    return back()->with('success', 'Profile updated successfully!');
}
}