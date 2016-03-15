<?php

namespace Nurmanhabib\Kewilayahan\DataSources;

use Illuminate\Support\Collection;
use Nurmanhabib\Kewilayahan\Contracts\DataSourceContract;

class SampleDataSource implements DataSourceContract
{
    public function getAllProvinsi()
    {
        return Collection::make([]);
    }

    public function getAllKabkota()
    {
        return Collection::make([]);
    }

    public function getAllKecamatan()
    {
        return Collection::make([]);
    }

    public function getAllDesa()
    {
        return Collection::make([]);
    }

    public function getKabkotaByProvinsi($provinsi_id)
    {
        return Collection::make([]);
    }

    public function getKecamatanByProvinsi($provinsi_id)
    {
        return Collection::make([]);
    }

    public function getKecamatanByKabkota($kabkota_id)
    {
        return Collection::make([]);
    }

    public function getDesaByProvinsi($provinsi_id)
    {
        return Collection::make([]);
    }

    public function getDesaByKabkota($kabkota_id)
    {
        return Collection::make([]);
    }

    public function getDesaByKecamatan($kecamatan_id)
    {  
        return Collection::make([]);
    }
}