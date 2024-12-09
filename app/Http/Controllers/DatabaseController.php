<?php

namespace App\Http\Controllers;

use App\Models\db\Divisi;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{
    public function index()
    {
        return view('db.index');
    }

    public function divisi(Request $request)
    {
        $data = Divisi::all();

        return view('db.divisi.index', [
            'data' => $data
        ]);
    }

    public function divisi_store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'url' => 'required',
        ]);

        $data['token'] = bin2hex(random_bytes(16));

        Divisi::create($data);

        return redirect()->route('db.divisi')->with('success', 'Data berhasil ditambahkan');

    }

    public function divisi_update(Request $request, Divisi $divisi)
    {
        $data = $request->validate([
            'nama' => 'required',
            'url' => 'required',
        ]);

        $divisi->update($data);

        return redirect()->route('db.divisi')->with('success', 'Data berhasil diubah');
    }

    public function divisi_delete(Divisi $divisi)
    {
        $divisi->delete();

        return redirect()->route('db.divisi')->with('success', 'Data berhasil dihapus');
    }

    public function divisi_regenerate_token(Divisi $divisi)
    {
        $divisi->update([
            'token' => bin2hex(random_bytes(16))
        ]);

        return redirect()->route('db.divisi')->with('success', 'Token berhasil diperbaharui');
    }
}
