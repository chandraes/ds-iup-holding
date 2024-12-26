<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\db\Divisi;
use App\Models\Pajak\RekapPpn;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HoldingController extends Controller
{
    public function checkConnection(Request $request)
    {

        $token = $request->bearerToken();
        $referer = $request->headers->get('referer');

        // Mencari divisi berdasarkan token
        $divisi = Divisi::where('token', $token)->first();

        // Cek apakah divisi ditemukan dan URL referer sesuai
        if (!$divisi || $referer != $divisi->url) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Connected to Holding API'
        ], 200);
    }

    public function ppn_masukan(Request $request)
    {
        try {
            // Validasi data request
            $data = $request->validate([
                'uraian' => 'required',
                'nominal' => 'required',
                'masukan_id' => 'required',
            ]);

            // Mendapatkan token dan referer dari request
            $token = $request->bearerToken();
            $referer = $request->headers->get('referer');

            // Mencari divisi berdasarkan token
            $divisi = Divisi::where('token', $token)->first();

            // Cek apakah divisi ditemukan dan URL referer sesuai
            if (!$divisi || $referer != $divisi->url) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Unauthorized'
                ], 401);
            }

            // Menghapus titik dari nominal
            $data['nominal'] = str_replace('.', '', $data['nominal']);
            $data['divisi_id'] = $divisi->id;

            $db = new RekapPpn();

            $store = $db->masukan($data);

            // Kembalikan respons berdasarkan hasil penyimpanan
            return response()->json([
                'code' => $store ? 200 : 500,
                'message' => $store ? 'Data PPN Masukan berhasil disimpan' : 'Data PPN Masukan gagal disimpan'
            ], $store ? 200 : 500);

        } catch (ValidationException $e) {
            // Kembalikan respons error validasi
            return response()->json([
                'code' => 422,
                'message' => 'Data PPN Masukan gagal disimpan',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function ppn_keluaran(Request $request)
    {
        try {
            // Validasi data request
            $data = $request->validate([
                'uraian' => 'required',
                'nominal' => 'required',
                'keluaran_id' => 'required',
            ]);

            // Mendapatkan token dan referer dari request
            $token = $request->bearerToken();
            $referer = $request->headers->get('referer');

            // Mencari divisi berdasarkan token
            $divisi = Divisi::where('token', $token)->first();

            // Cek apakah divisi ditemukan dan URL referer sesuai
            if (!$divisi || $referer != $divisi->url) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Unauthorized'
                ], 401);
            }

            // Menghapus titik dari nominal
            $data['nominal'] = str_replace('.', '', $data['nominal']);
            $data['divisi_id'] = $divisi->id;

            $db = new RekapPpn();

            $store = $db->keluaran($data);

            return response()->json($store);
            // Kembalikan respons berdasarkan hasil penyimpanan
            return response()->json([
                'code' => $store ? 200 : 500,
                'message' => $store ? 'Data PPN Keluaran berhasil disimpan' : 'Data PPN Keluaran gagal disimpan'. json_encode($store)
            ], $store ? 200 : 500);

        } catch (ValidationException $e) {
            // Kembalikan respons error validasi
            return response()->json([
                'code' => 422,
                'message' => 'Data PPN Keluaran gagal disimpan',
                'errors' => $e->errors(),
            ], 422);
        }

    }

    public function kas_besar_masuk(Request $request)
    {
        try {
            $data = $request->validate([
                'uraian' => 'required',
                'nominal' => 'required',
            ]);

            $token = $request->bearerToken();
            $referer = $request->headers->get('referer');

            $divisi = Divisi::where('token', $token)->first();

            // Cek apakah divisi ditemukan dan URL referer sesuai
            if (!$divisi || $referer != $divisi->url) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $data['nominal'] = str_replace('.', '', $data['nominal']);
            $data['divisi_id'] = $divisi->id;

            $db = new RekapPpn();

            $store = $db->kasBesar($data);

            if ($store['status'] == 'success') {
                return response()->json([
                    'code' => 200,
                    'message' => 'Data Kas Besar berhasil disimpan'
                ], 200);
            } else {
                return response()->json([
                    'code' => 500,
                    'message' => 'Data Kas Besar gagal disimpan',
                    'errors' => $store['message'],
                ], 500);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'code' => 422,
                'message' => 'Data Kas Besar gagal disimpan',
                'errors' => $th->getMessage(),
            ], 422);
        }
    }

    public function getRekening(Request $request)
    {
        $token = $request->bearerToken();
        $referer = $request->headers->get('referer');

        $divisi = Divisi::where('token', $token)->first();

        // Cek apakah divisi ditemukan dan URL referer sesuai
        if (!$divisi || $referer != $divisi->url) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        $rekening = Rekening::select('no_rek', 'nama_rek', 'bank')->where('untuk', 'kas-besar')->first();

        return response()->json($rekening);
    }
}
