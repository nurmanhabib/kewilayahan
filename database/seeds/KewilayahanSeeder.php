<?php

use Illuminate\Database\Seeder;

class KewilayahanSeeder extends Seeder
{
    public function run()
    {
        DB::table('kewilayahan_desa')->delete();
        DB::table('kewilayahan_kecamatan')->delete();
        DB::table('kewilayahan_kabkota')->delete();
        DB::table('kewilayahan_provinsi')->delete();

        $this->runProvinsi();
        $this->runKabkota();
        $this->runKecamatan();
        $this->runDesa();
    }

    protected function runProvinsi()
    {
        $json   = file_get_contents(__DIR__.'/json/kewilayahan_provinsi.json');
        $array  = json_decode($json, true);

        DB::table('kewilayahan_provinsi')->insert($array);
    }

    protected function runKabkota()
    {
        $json   = file_get_contents(__DIR__.'/json/kewilayahan_kabkota.json');
        $array  = json_decode($json, true);

        DB::table('kewilayahan_kabkota')->insert($array);
    }

    protected function runKecamatan()
    {
        $json   = file_get_contents(__DIR__.'/json/kewilayahan_kecamatan.json');
        $array  = json_decode($json, true);

        DB::table('kewilayahan_kecamatan')->insert($array);
    }

    protected function runDesa()
    {
        $json   = file_get_contents(__DIR__.'/json/kewilayahan_desa.json');
        $array  = json_decode($json, true);
        $chunk  = collect($array)->chunk(500);

        foreach ($chunk as $desa) {
            DB::table('kewilayahan_desa')->insert($desa->toArray());
        }
    }
}