<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('pengaturan.index');
    }

    public function akun(Request $request)
    {
        $db = new User();

        if (auth()->user()->role == 'su') {
            $data = $db->get();
        } else {
            $data = $db->where('role', '!=', 'su')->get();
        }

        $roles = $db->roles();
        // dd($roles);
        return view('pengaturan.akun.index', [
            'data' => $data,
            'roles' => $roles,
        ]);
    }

    public function akun_store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'name' => 'required|string',
            'role' => 'required|string',
            'email' => 'nullable|email',
            'password' => 'required|string',
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('pengaturan.akun')->with('success', 'Data berhasil ditambahkan');
    }

    public function akun_update(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'name' => 'required|string',
            'role' => 'required|string',
            'email' => 'nullable|email',
            'password' => 'nullable|string',
        ]);

        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('pengaturan.akun')->with('success', 'Data berhasil diubah');
    }

    public function akun_delete(User $user)
    {
        $db = new User();
        $count = $db->whereIn('role', ['su', 'Admin'])->count();
        // dd($count);
        if ($count < 2){
            return redirect()->route('pengaturan.akun')->with('error', 'Data tidak bisa dihapus, minimal harus ada 1 User Admin');
        }

        $user->delete();

        return redirect()->route('pengaturan.akun')->with('success', 'Data berhasil dihapus');
    }

    public function aplikasi()
    {
        $data = Aplikasi::first();
        return view('pengaturan.aplikasi.index', [
            'data' => $data,
        ]);
    }

    public function aplikasi_store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'logo' => 'nullable|image',
        ]);

        if ($request->hasFile('logo')) {
            $extension = $request->file('logo')->getClientOriginalExtension();
            $logoName = 'logo-aplikasi.' . $extension;
            $request->file('logo')->move(public_path('images'), $logoName);
            $validatedData['logo'] = $logoName;
        }

        $aplikasi = Aplikasi::first();

        if ($aplikasi) {
            $aplikasi->update($validatedData);
        } else {
            Aplikasi::create($validatedData);
        }

        return redirect()->route('pengaturan.aplikasi')->with('success', 'Data berhasil ditambahkan');
    }
}
