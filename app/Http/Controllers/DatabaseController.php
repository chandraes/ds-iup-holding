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
       $query = Divisi::query();

        // 1. Handle Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('url', 'like', "%{$search}%");
        }

        // 2. Handle Sorting (Default: ID descending)
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'desc');

        // Whitelist kolom agar user tidak inject SQL aneh-aneh
        if (in_array($sortField, ['nama', 'url', 'token', 'id'])) {
            $query->orderBy($sortField, $sortDirection);
        }

        // 3. Pagination (Gunakan paginate, BUKAN get)
        $data = $query->paginate(10)->withQueryString(); // withQueryString penting agar filter tidak hilang saat ganti halaman

        return view('db.divisi.index', compact('data'));
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
