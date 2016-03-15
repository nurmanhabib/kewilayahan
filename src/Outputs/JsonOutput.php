<?php

namespace Nurmanhabib\Kewilayahan\Outputs;

use Nurmanhabib\Kewilayahan\Contracts\OutputContract;

class JsonOutput implements OutputContract
{
	public function load($data)
	{
		return json_encode($data);
	}
}