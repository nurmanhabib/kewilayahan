<?php

namespace Nurmanhabib\Kewilayahan\Outputs;

use Nurmanhabib\Kewilayahan\Contracts\OutputContract;
use Illuminate\Support\Collection;

class ArrayOutput implements OutputContract
{
    public function load($data)
    {
        return (array) $data;
    }
}