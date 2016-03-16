<?php

namespace Nurmanhabib\Kewilayahan\Models;

class Kecamatan extends Model
{
    protected $table = 'kewilayahan_kecamatan';
    protected $casts = [
        'id' => 'string',
        'kabkota_id' => 'string',
    ];
    public $timestamps = false;

    public function kabkota()
    {
        return $this->belongsTo(Kabkota::class);
    }

    public function desa()
    {
        return $this->hasMany(Desa::class);
    }

    public function scopeWhereProvinsi($query, $provinsi_id)
    {
        return $query->where('provinsi_id', $provinsi_id);
    }
}