<?php

namespace Libra;

use Libra\App\Config;
use Libra\Database\Sqlite;

/**
 * Class ApiHelper
 *
 * @package Libra
 */
class ApiHelper
{
    /** @var Sqlite $sqlite */
    public $sqlite;
 
    /** @var array */
    private $options = [
        'json' => false,
        'json_pretty' => false,
        'dump' => false,
        'output' => true,
    ];
    
    /**
     * Api constructor.
     */
    function __construct()
    {
        $this->sqlite = new Sqlite();
        $this->options = (Object)$this->options;
    }
    
    /**
     * Change option in Api
     *
     * @param $option
     * @param $value
     */
    public function setOption($option, $value)
    {
        $this->options->{$option} = $value;
        return $this;
    }

    /**
     * @param $option
     * @return string|bool
     */
    public function getOption($option)
    {
        return $this->options->{$option} ?? false;
    }
    
    /**
     * Is an option enabled?
     *
     * @param $option
     * @return bool
     */
    public function isOptionEnabled($option)
    {
        return (isset($this->options->{$option}) && $this->options->{$option});
    }
    
    /**
     * handle data response
     *
     * @param $data
     * @param bool $filename
     * @return string
     */
    protected function respond($data, $filename = false, $forceSave = false)
    {
        // json option
        $jsonOption = $this->isOptionEnabled('json_pretty') ? JSON_PRETTY_PRINT : false;
        
        // if to dump the data or not
        if ($this->isOptionEnabled('dump') || $forceSave) {
            $filename = sprintf('%s_%s.json', $filename, date('Y-m-d_H-i-s'));
            file_put_contents(Config::DUMP_PATH .'/'. $filename, json_encode($data, $jsonOption));
        }
        
        return $this->isOptionEnabled('json') ? json_encode($data, $jsonOption) : $data;
    }
}