<?php

namespace Nurmanhabib\Kewilayahan\Models;

class Desa extends Model
{
    protected $table = 'kewilayahan_desa';
    public $timestamps = false;

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}