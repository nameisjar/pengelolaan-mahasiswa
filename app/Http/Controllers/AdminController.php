<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Mahasiswa;
use App\Models\Matkul;
use App\Models\Nilai;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('error', 'Email dan Password Salah!');
    }

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'prodis' => 'required',
            'no__hp' => 'required',
        ], [
            'nim.unique' => 'NIM sudah terpakai!'
        ]);

        $mahasiswa = new Mahasiswa();
        $mahasiswa->name = $validate['name'];
        $mahasiswa->nim = $validate['nim'];
        $mahasiswa->id__prodis = $validate['prodis'];
        $mahasiswa->no__hp = $validate['no__hp'];
        $mahasiswa->id_admin = Auth::guard('admin')->user()->id;

        $mahasiswa->save();
        return redirect()->back()->with('success', 'Data Mahasiswa Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $admin = Admin::all();
        $mahasiswa = Mahasiswa::orderBy('id', 'asc')->paginate(7);
        $prodi = Prodi::all();

        return view('dashboard', compact('admin', 'mahasiswa', 'prodi'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $prodi = Prodi::all();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        return view('edit-mahasiswa', compact('mahasiswa', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $validate = $request->validate([
            'name' => 'required',
            'nim' => 'required|unique:mahasiswas,nim,' . $id,
            'prodis' => 'required',
            'no__hp' => 'required',
        ], [
            'nim.unique' => 'NIM sudah terpakai!'
        ]);

        $mahasiswa->name = $validate['name'];
        $mahasiswa->nim = $validate['nim'];
        $mahasiswa->id__prodis = $validate['prodis'];
        $mahasiswa->no__hp = $validate['no__hp'];

        $mahasiswa->save();
        return redirect()->back()->with('error', 'NIM sudah terpakai!')->withInput();
        return redirect()->back()->with('success', 'Data Mahasiswa Berhasil Diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $mahasiswa->delete();

        return redirect()->back()->with('success', 'Data mahasiswa berhasil dihapus.');
    }




    //input nilai

    public function show2(Mahasiswa $mahasiswa)
    {
        $matkul = Matkul::all();
        $nilai = Nilai::where('id__mahasiswa', $mahasiswa->id)->paginate(7);
        $namaMahasiswa = Mahasiswa::find($mahasiswa->id)->name; // Mengambil nama mahasiswa berdasarkan ID
        return view('inputNilai', compact('mahasiswa', 'nilai', 'matkul', 'namaMahasiswa'));
    }


    public function store2(Request $request, $id)
    {
        $validate = $request->validate([
            'matkul' => 'required',
            'nilai' => 'required',
        ]);

        // Periksa apakah 'matkul' sudah terisi
        $existingNilai = Nilai::where('id__mahasiswa', $id)
            ->where('id__matkul', $validate['matkul'])
            ->first();

        if ($existingNilai) {
            return redirect()->back()->with('error', 'Matkul sudah ada!');
        }

        $nilai = new Nilai();
        $nilai->id__mahasiswa = $id;
        $nilai->id__matkul = $validate['matkul'];
        $nilai->nilai = $validate['nilai'];

        // Menentukan grade berdasarkan nilai
        if ($nilai->nilai >= 85) {
            $nilai->grade = 'A';
        } elseif ($nilai->nilai >= 75) {
            $nilai->grade = 'B';
        } elseif ($nilai->nilai >= 65) {
            $nilai->grade = 'C';
        } elseif ($nilai->nilai >= 50) {
            $nilai->grade = 'D';
        } else {
            $nilai->grade = 'E';
        }

        $nilai->save();
        return redirect()->back()->with('success', 'Data Nilai Mahasiswa Berhasil Ditambahkan.');
    }

    public function destroy2($id)
    {
        $nilai = Nilai::find($id);

        if (!$nilai) {
            return redirect()->back()->with('error', 'Data nilai tidak ditemukan.');
        }

        $nilai->delete();

        return redirect()->back()->with('success', 'Data nilai berhasil dihapus.');
    }

    public function updateAdmin(Request $request)
    {
        $request->validate([
            'foto' => 'mimes:jpeg,jpg,png,gif',
        ], [
            'foto.mimes' => 'File foto hanya boleh berekstensi JPEG, JPG, PNG, dan GIF'
        ]);

        $user = Auth::guard('admin')->user();

        // Menghapus gambar lama jika ada
        $oldImage = Auth::guard('admin')->user()->foto;
        if ($request->hasFile('foto') && $oldImage) {
            Storage::delete($oldImage);
        }

        //Mengupdate gambar yang sudah ada di database tanpa harus menambah file gambar
        if ($request->hasFile('foto')) {
            $file_name = $request->foto->getClientOriginalName();
            $image = $request->foto->storeAs('images', $file_name);
            $user->foto = $image;
        }
        $user->save();
        return redirect('/dashboard')->with('success', 'Profil Berhasil Diperbarui');
    }
}
