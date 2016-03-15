<?php

namespace Nurmanhabib\Kewilayahan\Outputs;

use Nurmanhabib\Kewilayahan\Contracts\OutputContract;
use Illuminate\Support\Collection;

class JsonApiOutput implements OutputContract
{
    protected $pluck_key;
    protected $pluck_value;
    protected $prepends = [['' => '--']];
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

    public function selected($value)
    {
        $this->appends([['selected' => $value]]);

        return $this;
    }

    public function prepends($prepends)
    {
        $this->prepends = array_merge($prepends, $this->prepends);

        return $this;
    }

    public function appends($appends)
    {
        $this->appends = array_merge($this->appends, $appends);

        return $this;
    }

    public function load($data)
    {
        $prepends   = $this->prepends;
        $appends    = $this->appends;
        $plucked    = $this->plucked($data);
        $plucked    = array_merge($prepends, $plucked, $appends);

        return $plucked;
    }

    protected function plucked($data)
    {
        return Collection::make($data)->map(function ($item) {
            $key    = $item[$this->pluck_key];
            $value  = $item[$this->pluck_value];

            return [$key => $value];
        })->toArray();
    }
}