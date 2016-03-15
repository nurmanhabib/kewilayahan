<?php

namespace Nurmanhabib\Kewilayahan\Outputs;

use Nurmanhabib\Kewilayahan\Contracts\OutputContract;
use Illuminate\Support\Collection;

class PluckedArrayOutput implements OutputContract
{
    protected $pluck_key;
    protected $pluck_value;
    protected $prepends = ['' => '--'];
    protected $appends = [];

    public function __construct($value = 'name', $key = 'id', $prepends = null, $appends = null)
    {
        $this->pluck_key    = $key;
        $this->pluck_value  = $value;

        if ($prepends)
            $this->prepends = $prepends;

        if ($appends)
            $this->appends = $appends;
    }

    public function load($data)
    {
        $prepends   = $this->prepends;
        $appends    = $this->appends;
        $plucked    = $this->plucked($data);
        $plucked    = $prepends + $plucked + $appends;

        return $plucked;
    }

    protected function plucked($data)
    {
        return Collection::make($data)->pluck($this->pluck_value, $this->pluck_key)->toArray();
    }
}