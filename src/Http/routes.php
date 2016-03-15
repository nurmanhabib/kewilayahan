<?php

use Illuminate\Http\Request;

$router->get('/', function (Request $request) {
    $kewilayahan = app('kewilayahan');
    $kewilayahan->setQuery($request->all());
    $kewilayahan->setOutput('api');

    if ($request->has('selected')) {
        $kewilayahan->setOutput(function ($data) use ($request) {
            $selected = $request->only('selected');
            
            return array_merge($data, [$selected]);
        });
    }

    return $kewilayahan->load();
});
