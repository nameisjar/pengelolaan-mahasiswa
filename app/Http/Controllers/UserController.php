<?php

namespace App\Http\Controllers;

use App\Models\JenisKendaraan;
use App\Models\Parkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('signin');
    }
    public function index1()
    {
        return view('dashboard');
    }

    public function showTambahParkir()
    {
        $parkir = Parkir::all();
        $jenis_kendaraan = JenisKendaraan::all();

        return view('dashboard', compact('parkir', 'jenis_kendaraan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function tambahParkir(Request $request)
    {

        // Validasi input
        $jenisKendaraan = $request->jenis_kendaraan;

        $jumlahParkirMotor = Parkir::where('id_jenis_kendaraan', 1)->count();
        $jumlahParkirMobil = Parkir::where('id_jenis_kendaraan', 2)->count();

        if ($jenisKendaraan == 1 && $jumlahParkirMotor >= 5) {
            return redirect()->back()->with('error', 'Batas jumlah parkir motor telah tercapai.');
        }

        if ($jenisKendaraan == 2 && $jumlahParkirMobil >= 5) {
            return redirect()->back()->with('error', 'Batas jumlah parkir mobil telah tercapai.');
        }

        $validate = $request->validate([
            'plat_nomor' => 'required',
            'jenis_kendaraan' => 'required',
        ]);

        $parkir = new Parkir();
        $parkir->plat_nomor = $validate['plat_nomor'];
        $parkir->id_jenis_kendaraan = $validate['jenis_kendaraan'];
        $parkir->id_admin = 1;

        $parkir->save();

        return redirect()->back()->with('success', 'Data parkir berhasil ditambahkan.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirimkan oleh pengguna
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Melakukan proses otentikasi
        if (Auth::attempt($credentials)) {
            // Jika otentikasi berhasil, alihkan pengguna ke rute yang diinginkan
            return redirect()->intended('/');
        } else {
            // Jika otentikasi gagal, kembali ke halaman login dengan pesan error
            return back()->with('error', 'Email atau password salah.');
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('signin_index')->with('success', 'Anda telah berhasil keluar.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
