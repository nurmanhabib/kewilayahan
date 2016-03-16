<?php

namespace Nurmanhabib\Kewilayahan\Models;

class Provinsi extends Model
{
    protected $table = 'kewilayahan_provinsi';
    protected $casts = [
	    'id' => 'string',
	];
    public $timestamps = false;

    public function kabkota()
    {
        return $this->hasMany(Kabkota::class);
    }
}