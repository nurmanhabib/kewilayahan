<?php

namespace Nurmanhabib\Kewilayahan\DataSources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nurmanhabib\Kewilayahan\Contracts\DataSourceContract;
use Nurmanhabib\Kewilayahan\Models\Provinsi;
use Nurmanhabib\Kewilayahan\Models\Kabkota;
use Nurmanhabib\Kewilayahan\Models\Kecamatan;
use Nurmanhabib\Kewilayahan\Models\Desa;

class EloquentDataSource implements DataSourceContract
{
    protected $provinsi;
    protected $kabkota;
    protected $kecamatan;
    protected $desa;

    public function __construct($models)
    {
        $provinsi   = $this->make($models['provinsi']);
        $kabkota    = $this->make($models['kabkota']);
        $kecamatan  = $this->make($models['kecamatan']);
        $desa       = $this->make($models['desa']);
        
        if ($provinsi instanceof Provinsi)
            $this->provinsi = $provinsi;
        
        if ($kabkota instanceof Kabkota)
            $this->kabkota = $kabkota;
        
        if ($kecamatan instanceof Kecamatan)
            $this->kecamatan = $kecamatan;
        
        if ($desa instanceof Desa)
            $this->desa = $desa;
    }

    protected function make($model)
    {
        $instance = new $model;
        $instance->orderBy('id', 'asc');

        return $instance;
    }

    public function getAllProvinsi()
    {
        return $this->provinsi->all();
    }

    public function getAllKabkota()
    {
        return $this->kabkota->all();
    }

    public function getAllKecamatan()
    {
        return $this->kecamatan->all();
    }

    public function getAllDesa()
    {
        return $this->desa->all();
    }

    public function getKabkotaByProvinsi($provinsi_id)
    {
        $provinsi = $this->provinsi->find($provinsi_id);

        if ($provinsi)
            return $provinsi->kabkota;
            return [];
    }

    public function getKecamatanByProvinsi($provinsi_id)
    {
        $provinsi   = $this->provinsi->find($provinsi_id);
        $results    = [];

        if ($provinsi) {
            foreach ($provinsi->kabkota as $kabkota) {
                $kecamatan  = $kabkota->kecamatan->toArray();
                $results    = array_merge($results, $kecamatan);
            }
        }

        return Collection::make($results);
    }

    public function getKecamatanByKabkota($kabkota_id)
    {
        $kabkota = $this->kabkota->find($kabkota_id);

        if ($kabkota)
            return $kabkota->kecamatan;
            return [];
    }

    public function getDesaByProvinsi($provinsi_id)
    {
        return [];
    }

    public function getDesaByKabkota($kabkota_id)
    {
        return [];
    }

    public function getDesaByKecamatan($kecamatan_id)
    {
        $kecamatan = $this->kecamatan->find($kecamatan_id);

        if ($kecamatan)
            return $kecamatan->desa;
            return [];
    }
}