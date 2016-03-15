<?php

return [
    'default' => [
        'datasource'    => 'eloquent',
        'output'        => 'collection',
    ],

    'api' => [
        'enable'    => true,
        'path'      => 'api/v1/kewilayahan',
    ],

    'datasources' => [
        'sample' => [
            'class' => Nurmanhabib\Kewilayahan\DataSources\SampleDataSource::class,
        ],
        
        'eloquent' => [
            'class' => Nurmanhabib\Kewilayahan\DataSources\EloquentDataSource::class,
            'models' => [
                'provinsi'  => Nurmanhabib\Kewilayahan\Models\Provinsi::class,
                'kabkota'   => Nurmanhabib\Kewilayahan\Models\Kabkota::class,
                'kecamatan' => Nurmanhabib\Kewilayahan\Models\Kecamatan::class,
                'desa'      => Nurmanhabib\Kewilayahan\Models\Desa::class,
            ],
        ],
    ],

    'outputs' => [
        'array'         => Nurmanhabib\Kewilayahan\Outputs\ArrayOutput::class,
        'collection'    => Nurmanhabib\Kewilayahan\Outputs\CollectionOutput::class,
        'json'          => Nurmanhabib\Kewilayahan\Outputs\JsonOutput::class,
        'api'           => Nurmanhabib\Kewilayahan\Outputs\JsonApiOutput::class,
    ],
];