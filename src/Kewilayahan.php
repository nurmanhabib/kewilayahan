<?php

namespace Nurmanhabib\Kewilayahan;

use Closure;
use Illuminate\Support\Collection;
use Nurmanhabib\Kewilayahan\Contracts\DataSourceContract;
use Nurmanhabib\Kewilayahan\Contracts\OutputContract;
use Nurmanhabib\Kewilayahan\Factories\OutputFactory;

class Kewilayahan
{
    protected $datasouce;
    protected $output;
    protected $outputCallback;
    protected $config = [];

    protected $tableName;
    protected $tableWhereId;

    public function __construct(DataSourceContract $datasource, OutputContract $output, array $config = [])
    {
        $this->setQuery();
        $this->loadConfig($config);
        $this->setDataSource($datasource);
        $this->setOutput($output);
    }

    public function setDataSource(DataSourceContract $datasource)
    {
        $this->datasouce = $datasource;

        return $this;
    }

    public function setOutput($output, $params = [])
    {
        if (is_callable($output)) {
            $this->setOutputCallback($output);

            $output = null;
        }

        if (is_callable($params)) {
            return $this->setOutputCallback($params);

            $params = [];
        }

        if ($output !== null)
            $this->output = OutputFactory::make($output, $params);

        return $this->output;
    }

    public function setOutputCallback(Closure $callback)
    {
        $this->outputCallback = $callback;

        return $this;
    }

    public function setQuery(array $query = [])
    {
        $query = Collection::make($query);

        if ($query->has('kecamatan_id')) {
            $this->tableName = 'desa';
            $this->tableWhereId = $query->get('kecamatan_id');
        }

        elseif ($query->has('kabkota_id')) {
            $this->tableName = 'kecamatan';
            $this->tableWhereId = $query->get('kabkota_id');
        }

        elseif ($query->has('provinsi_id')) {
            $this->tableName = 'kabkota';
            $this->tableWhereId = $query->get('provinsi_id');
        }

        else {
            $this->tableName = 'provinsi';
            $this->tableWhereId = 0;
        }
    }

    public function load($tableOrArray = null, $whereOrCallback = null)
    {
        if (is_callable($whereOrCallback)) {
            return $this->loadCallback($tableOrArray, $whereOrCallback);
        }

        $tableName      = $tableOrArray ?: $this->tableName;
        $tableWhereId   = $whereOrCallback ?: $this->tableWhereId;

        if ($tableWhereId === 0) {
            $method = 'getAll' . ucfirst($tableName);
            $data   = $this->datasouce->{$method}();
            
            return $this->response($data);
        } else {
            $method = 'load' . ucfirst($tableName);
            
            return call_user_func_array([$this, $method], [$tableWhereId]);
        }
    }

    public function loadCallback(array $tableAndWhere, Closure $callback)
    {
        if (!array_key_exists(0, $tableAndWhere))
            $tableAndWhere[0] = 'provinsi';

        if (!array_key_exists(1, $tableAndWhere))
            $tableAndWhere[1] = 0;
        
        $table      = $tableAndWhere[0];
        $whereId    = $tableAndWhere[1];
        $output     = $this->load($table, $whereId);

        return $callback($output);
    }

    public function loadKabkota($provinsi_id)
    {
        $data = $this->datasouce->getKabkotaByProvinsi($provinsi_id);

        return $this->response($data);
    }

    public function loadKecamatan($kabkota_id)
    {
        $data = $this->datasouce->getKecamatanByKabkota($kabkota_id);

        return $this->response($data);
    }

    public function loadDesa($kecamatan_id)
    {
        $data = $this->datasouce->getDesaByKecamatan($kecamatan_id);

        return $this->response($data);
    }

    protected function response($data)
    {
        $load = $this->output->load($data);

        if (is_callable($this->outputCallback)) {
            $callback = $this->outputCallback;

            return $callback($load);
        }

        return $load;
    }

    public function loadConfig(array $config = [])
    {
        $loader = ConfigLoader::load();
        $loader->appends($config);
        
        $this->config = $loader->toArray();

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }
}