<?php

namespace App\Models\Pajak;

use App\Models\db\Divisi;
use App\Models\GroupWa;
use App\Models\KasBesar;
use App\Models\Rekening;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RekapPpn extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['tanggal', 'nf_nominal', 'nf_saldo'];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function dataTahun()
    {
        return $this->selectRaw('YEAR(created_at) as tahun')->groupBy('tahun')->get();
    }

    public function rekapByMonth($month, $year)
    {
        return $this->with(['divisi'])->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
    }

    public function rekapByMonthSebelumnya($month, $year)
    {
        $data = $this->with(['divisi'])->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if (!$data) {
            $data = $this->where('created_at', '<', Carbon::create($year, $month, 1))
                    ->orderBy('id', 'desc')
                    ->first();
        }

        return $data;
    }

    public function getTanggalAttribute()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }

    public function getNfNominalAttribute()
    {
        return number_format($this->nominal, 0, ',', '.');
    }

    public function getNfSaldoAttribute()
    {
        return number_format($this->saldo, 0, ',', '.');
    }

    public function saldoTerakhir()
    {
        return $this->orderBy('id', 'desc')->first()->saldo ?? 0;
    }

    public function masukan($data)
    {
        try {
            DB::beginTransaction();

            $saldo = $this->saldoTerakhir() + $data['nominal'];

            $store = $this->create([
                'divisi_id' => $data['divisi_id'],
                'uraian' => $data['uraian'],
                'nominal' => $data['nominal'],
                'jenis' => 1,
                'saldo' => $saldo,
                'masukan_id' => $data['masukan_id'],
            ]);

            $db = new GroupWa();

            $tujuan = $db->where('untuk', 'kas-besar')->first()->nama_group;

            $divisi = Divisi::find($data['divisi_id']);

            $pesan = "🟤🟤🟤🟤🟤🟤🟤🟤🟤\n".
                    "*PPN Masukan*\n".
                    "🟤🟤🟤🟤🟤🟤🟤🟤🟤\n\n".
                    "Divisi  : ".$divisi->nama."\n".
                    "Uraian  : ".$store->uraian."\n".
                    "Nominal :  *Rp. ".number_format($store->nominal, 0, ',', '.')."*\n\n".
                    // "Ditransfer ke rek:\n\n".
                    // "Bank      : ".$store->bank."\n".
                    // "Nama    : ".$store->nama_rek."\n".
                    // "No. Rek : ".$store->no_rek."\n\n".
                    "==========================\n".
                    "Sisa Saldo PPN: \n".
                    "Rp. ".number_format($this->saldoTerakhir(), 0, ',', '.')."\n\n".
                    // "Sisa Saldo Kas Besar  NON PPN: \n".
                    // "Rp. ".number_format($kasNonPpn['saldo'], 0, ',', '.')."\n\n".
                    // "Total Modal Investor : \n".
                    // "Rp. ".number_format($totalModal, 0, ',', '.')."\n\n".
                    "Terima kasih 🙏🙏🙏\n";

            $db->sendWa($tujuan, $pesan);

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function keluaran($data)
    {
        try {
            DB::beginTransaction();


            $saldo = $this->saldoTerakhir() - $data['nominal'];

            $store = $this->create([
                'divisi_id' => $data['divisi_id'],
                'uraian' => $data['uraian'],
                'nominal' => $data['nominal'],
                'jenis' => 0,
                'saldo' => $saldo,
                'keluaran_id' => $data['keluaran_id'],
            ]);

            $db = new GroupWa();

            $tujuan = $db->where('untuk', 'kas-besar')->first()->nama_group;

            $divisi = Divisi::find($data['divisi_id']);

            $pesan = "🟤🟤🟤🟤🟤🟤🟤🟤🟤\n".
                    "*PPN Keluaran*\n".
                    "🟤🟤🟤🟤🟤🟤🟤🟤🟤\n\n".
                    "Divisi  : ".$divisi->nama."\n".
                    "Uraian  : ".$store->uraian."\n".
                    "Nominal :  *Rp. ".number_format($store->nominal, 0, ',', '.')."*\n\n".
                    // "Ditransfer ke rek:\n\n".
                    // "Bank      : ".$store->bank."\n".
                    // "Nama    : ".$store->nama_rek."\n".
                    // "No. Rek : ".$store->no_rek."\n\n".
                    "==========================\n".
                    "Sisa Saldo PPN: \n".
                    "Rp. ".number_format($this->saldoTerakhir(), 0, ',', '.')."\n\n".
                    // "Sisa Saldo Kas Besar  NON PPN: \n".
                    // "Rp. ".number_format($kasNonPpn['saldo'], 0, ',', '.')."\n\n".
                    // "Total Modal Investor : \n".
                    // "Rp. ".number_format($totalModal, 0, ',', '.')."\n\n".
                    "Terima kasih 🙏🙏🙏\n";

            $db->sendWa($tujuan, $pesan);

            DB::commit();

            return true;

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return false;
        }
    }

    public function kasBesar($data)
    {
        try {
            DB::beginTransaction();

            $db = new KasBesar();

            $saldo = $db->saldoTerakhir() + $data['nominal'];
            $rekening = Rekening::where('untuk', 'kas-besar')->first();

            $store = $db->create([
                'divisi_id' => $data['divisi_id'],
                'uraian' => $data['uraian'],
                'nominal' => $data['nominal'],
                'jenis' => 1,
                'saldo' => $saldo,
                'no_rek' => $rekening->no_rek,
                'nama_rek' => $rekening->nama_rek,
                'bank' => $rekening->bank,
                'modal_investor_terakhir' => $db->modalInvestorTerakhir()
            ]);

            $dbWa = new GroupWa();

            $tujuan = $dbWa->where('untuk', 'kas-besar')->first()->nama_group;
            $saldoPpn = $this->saldoTerakhir();

            $divisi = Divisi::find($data['divisi_id']);

            $pesan = "🔵🔵🔵🔵🔵🔵🔵🔵🔵\n".
                    "*Form Kas Besar*\n".
                    "🔵🔵🔵🔵🔵🔵🔵🔵🔵\n\n".
                    "Divisi  : ".$divisi->nama."\n".
                    "Uraian  : ".$store->uraian."\n".
                    "Nominal :  *Rp. ".number_format($store->nominal, 0, ',', '.')."*\n\n".
                    "Ditransfer ke rek:\n\n".
                    "Bank      : ".$rekening->bank."\n".
                    "Nama    : ".$rekening->nama_rek."\n".
                    "No. Rek : ".$rekening->no_rek."\n\n".
                    "==========================\n".
                    "Sisa Saldo Kas Besar: \n".
                    "Rp. ".number_format($db->saldoTerakhir(), 0, ',', '.')."\n\n".
                    "Sisa Saldo PPN: \n".
                    "Rp. ".number_format($saldoPpn, 0, ',', '.')."\n\n".
                    // "Total Modal Investor : \n".
                    // "Rp. ".number_format($totalModal, 0, ',', '.')."\n\n".
                    "Terima kasih 🙏🙏🙏\n";

            $dbWa->sendWa($tujuan, $pesan);

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Data berhasil disimpan'
            ];
        } catch (\Throwable $th){
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $th->getMessage(),
            ];
        }
    }

    public function bayar_ppn()
    {

        $dbKas = new KasBesar();

        $saldoPpn = $this->saldoTerakhir();

        if ($saldoPpn > 0) {
            return [
                'status' => 'error',
                'message' => 'Belum bisa dilakukan pembayaran PPN karena saldo PPN Masukan masih tersedia!'
            ];
        }

        $saldoKasBesar = $dbKas->saldoTerakhir();

        // buat saldoppn menjadi positif
        $saldoPpn = abs($saldoPpn);

        if ($saldoKasBesar < $saldoPpn) {
            return [
                'status' => 'error',
                'message' => 'Saldo Kas Besar tidak mencukupi untuk pembayaran PPN!'
            ];
        }

        try {
            DB::beginTransaction();

            $saldo = $dbKas->saldoTerakhir() - $saldoPpn;

            $store = $dbKas->create([
                'uraian' => 'Pembayaran PPN',
                'nominal' => $saldoPpn,
                'jenis' => 0,
                'saldo' => $saldo,
                'no_rek' => 'PAJAK',
                'nama_rek' => 'PAJAK',
                'bank' => 'PAJAK',
                'modal_investor_terakhir' => $dbKas->modalInvestorTerakhir()
            ]);

            $rekap = $this->create([
                'uraian' => 'Kas Besar',
                'nominal' => $saldoPpn,
                'jenis' => 1,
                'saldo' => $this->saldoTerakhir() + $saldoPpn,
            ]);

            $dbWa = new GroupWa();

            $tujuan = $dbWa->where('untuk', 'kas-besar')->first()->nama_group;

            $pesan = "🔵🔵🔵🔵🔵🔵🔵🔵🔵\n".
                    "*Pembayaran PPN*\n".
                    "🔵🔵🔵🔵🔵🔵🔵🔵🔵\n\n".
                    "Uraian  : ".$store->uraian."\n".
                    "Nominal :  *Rp. ".number_format($store->nominal, 0, ',', '.')."*\n\n".
                    "Ditransfer ke rek:\n\n".
                    "Bank      : ".$store->bank."\n".
                    "Nama    : ".$store->nama_rek."\n".
                    "No. Rek : ".$store->no_rek."\n\n".
                    "==========================\n".
                    "Sisa Saldo Kas Besar: \n".
                    "Rp. ".number_format($dbKas->saldoTerakhir(), 0, ',', '.')."\n\n".
                    // "Sisa Saldo PPN: \n".
                    // "Rp. ".number_format($saldoPpn, 0, ',', '.')."\n\n".
                    // "Total Modal Investor : \n".
                    // "Rp. ".number_format($totalModal, 0, ',', '.')."\n\n".
                    "Terima kasih 🙏🙏🙏\n";

            $dbWa->sendWa($tujuan, $pesan);

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Data berhasil disimpan'
            ];
        } catch (\Throwable $th){
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $th->getMessage(),
            ];
        }

    }
}
