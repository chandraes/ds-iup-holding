<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use App\Models\GroupWa;
use App\Models\User;
use App\Services\WaStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('pengaturan.index');
    }

    public function akun(Request $request)
    {
        $db = new User();

        if (Auth::user()->role == 'su') {
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

    public function aplikasi_update(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg',
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

    public function group_wa()
    {
        $data = GroupWa::whereNot('untuk', 'team')->get();
        return view('pengaturan.wa.index', [
            'data' => $data
        ]);
    }

    public function get_group_wa()
    {
        $wa = new WaStatus();
        $group = $wa->getGroup();

        return response()->json($group['data']['groups']);
    }

    public function group_wa_update(Request $request, GroupWa $group)
    {
        $data = $request->validate([
            'nama_group' => 'required',
            'group_id' => 'required',
        ]);

        $group->update($data);

        return redirect()->back()->with('success', 'Data berhasil diubah.');
    }
}
