<?php

namespace Nurmanhabib\Kewilayahan\Contracts;

interface DataSourceContract
{
    public function getAllProvinsi();

    public function getAllKabkota();

    public function getAllKecamatan();

    public function getAllDesa();

    public function getKabkotaByProvinsi($provinsi_id);

    public function getKecamatanByProvinsi($provinsi_id);

    public function getKecamatanByKabkota($kabkota_id);

    public function getDesaByProvinsi($provinsi_id);

    public function getDesaByKabkota($kabkota_id);

    public function getDesaByKecamatan($kecamatan_id);
}