<?php

namespace App\Models;

use App\Services\StarSender;
use Illuminate\Database\Eloquent\Model;

class GroupWa extends Model
{
    protected $guarded = ['id'];

    public function sendWa($tujuan, $pesan)
    {
        $storeWa = PesanWa::create([
            'pesan' => $pesan,
            'tujuan' => $tujuan,
            'status' => 0,
        ]);

        $send = new StarSender($tujuan, $pesan);
        $res = $send->sendGroup();

        if ($res == 'true') {
            $storeWa->update(['status' => 1]);
        }

    }

    // public function generateMessage($isIn, $title, $uraian, $nominal, $rekening, $additionalMessage = null)
    // {

    //     $lineHeading = $isIn == 1 ? "🔵🔵🔵🔵🔵🔵🔵🔵🔵\n" : "🔴🔴🔴🔴🔴🔴🔴🔴🔴\n";

    //     $kasBesar = new KasBesar();

    //     $kasPpnP = [
    //         'saldo' => $kasBesar->saldoTerakhir(),
    //         'modal_investor' => $kasBesar->modalInvestorTerakhir(),
    //     ];

    //     $sisaSaldo = '';

    //     $sisaSaldo .= "Sisa Saldo Kas Besar PPN: \n".
    //                 "Rp. ".number_format($kasPpnP['saldo'], 0, ',', '.')."\n\n".
    //             "Total Modal Investor PPN: \n".
    //             "Rp. ".number_format($kasPpnP['modal_investor'], 0, ',', '.')."\n\n";


    //     $pesan =   $lineHeading.
    //                 "*".$title."*\n".
    //                 $lineHeading."\n".
    //                 "Uraian : ".$uraian."\n".
    //                 "Nilai :  *Rp. ".number_format($nominal, 0, ',', '.')."*\n\n".
    //                 "Ditransfer ke rek:\n\n".
    //                 "Bank      : ".$rekening['bank']."\n".
    //                 "Nama    : ".$rekening['nama_rek']."\n".
    //                 "No. Rek : ".$rekening['no_rek']."\n\n".
    //                 "==========================\n".
    //                 $sisaSaldo.
    //                 $additionalMessage.
    //                 "Terima kasih 🙏🙏🙏\n";

    //     return $pesan;

    // }
}
