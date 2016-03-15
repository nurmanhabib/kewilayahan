<?php

namespace Nurmanhabib\Kewilayahan\Models;

class Kabkota extends Model
{
    protected $table = 'kewilayahan_kabkota';
    public $timestamps = false;

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class);
    }

    public function scopeWhereProvinsi($query, $provinsi_id)
    {
        return $query->where('provinsi_id', $provinsi_id);
    }
}