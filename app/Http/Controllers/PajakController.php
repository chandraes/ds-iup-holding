<?php

namespace App\Http\Controllers;

use App\Models\Pajak\RekapPpn;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PajakController extends Controller
{
    public function index()
    {
        return view('pajak.index');
    }

    public function rekap_ppn(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $db = new RekapPpn();

        $data = $db->rekapByMonth($bulan, $tahun);
        $dataTahun = $db->dataTahun();

        $bulanSebelumnya = $bulan - 1;
        $bulanSebelumnya = $bulanSebelumnya == 0 ? 12 : $bulanSebelumnya;
        $tahunSebelumnya = $bulanSebelumnya == 12 ? $tahun - 1 : $tahun;
        $stringBulan = Carbon::createFromDate($tahun, $bulanSebelumnya)->locale('id')->monthName;
        $stringBulanNow = Carbon::createFromDate($tahun, $bulan)->locale('id')->monthName;

        $dataSebelumnya = $db->rekapByMonthSebelumnya($bulanSebelumnya, $tahunSebelumnya);

        return view('pajak.rekap-ppn.index', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'dataTahun' => $dataTahun,
            'dataSebelumnya' => $dataSebelumnya,
            'stringBulan' => $stringBulan,
            'stringBulanNow' => $stringBulanNow,
            'bulanSebelumnya' => $bulanSebelumnya,
            'tahunSebelumnya' => $tahunSebelumnya
        ]);
    }
}
