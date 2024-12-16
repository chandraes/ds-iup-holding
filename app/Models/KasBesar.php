<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class KasBesar extends Model
{
    protected $guarded = ['id'];

    public function dataTahun()
    {
        return $this->selectRaw('YEAR(created_at) as tahun')->groupBy('tahun')->get();
    }

    public function getKodeDepositAttribute()
    {
        return $this->nomor_deposit != null ? 'D'.str_pad($this->nomor_deposit, 2, '0', STR_PAD_LEFT) : '';
    }

    public function getNfModalInvestorAttribute()
    {
        return $this->modal_investor != null ?  number_format($this->modal_investor, 0, ',', '.') : 0;
    }

    public function getNfSaldoAttribute()
    {
        return number_format($this->saldo, 0, ',', '.');
    }

    public function getNfNominalAttribute()
    {
        return number_format($this->nominal, 0, ',', '.');
    }

    public function getTanggalAttribute()
    {
        return date('d-m-Y', strtotime($this->created_at));
    }

    public function saldoTerakhir()
    {
        return $this->orderBy('id', 'desc')->first()->saldo ?? 0;
    }

    public function modalInvestorTerakhir()
    {
        return $this->orderBy('id', 'desc')->first()->modal_investor_terakhir ?? 0;
    }

    public function kasBesar($month, $year)
    {
        return $this->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
    }

    public function kasBesarByMonth($month, $year)
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

}
