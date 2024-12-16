<?php

namespace App\Models\Pajak;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RekapPpn extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['tanggal', 'nf_nominal', 'nf_saldo'];

    public function dataTahun()
    {
        return $this->selectRaw('YEAR(created_at) as tahun')->groupBy('tahun')->get();
    }

    public function rekapByMonth($month, $year)
    {
        return $this->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
    }

    public function rekapByMonthSebelumnya($month, $year)
    {
        $data = $this->whereMonth('created_at', $month)
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
}
