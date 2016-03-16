<?php

namespace Nurmanhabib\Kewilayahan\Models;

class Kabkota extends Model
{
    protected $table = 'kewilayahan_kabkota';
    protected $casts = [
        'id' => 'string',
        'provinsi_id' => 'string',
    ];
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