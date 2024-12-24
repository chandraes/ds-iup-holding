<?php

namespace App\Models\Pajak;

use App\Models\db\Divisi;
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

            $this->create([
                'divisi_id' => $data['divisi_id'],
                'uraian' => $data['uraian'],
                'nominal' => $data['nominal'],
                'jenis' => 1,
                'saldo' => $saldo,
                'masukan_id' => $data['masukan_id'],
            ]);

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

            $this->create([
                'divisi_id' => $data['divisi_id'],
                'uraian' => $data['uraian'],
                'nominal' => $data['nominal'],
                'jenis' => 0,
                'saldo' => $saldo,
                'keluaran_id' => $data['keluaran_id'],
            ]);

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return false;
        }
    }
}
