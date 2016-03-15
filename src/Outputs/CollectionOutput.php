<?php

namespace Nurmanhabib\Kewilayahan\Outputs;

use Closure;
use Nurmanhabib\Kewilayahan\Contracts\OutputContract;
use Illuminate\Support\Collection;

class CollectionOutput implements OutputContract
{
    public function load($data)
    {
        return Collection::make($data);
    }
}