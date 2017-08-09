<?php

namespace Libra;
use Libra\App\Config;

/**
 * Class Api
 *
 * @package Libra
 */
class Api extends ApiHelper
{
    /**
     * Get a list of sqlite tables
     *
     * @return string|array
     */
    public function getTableList()
    {
        $sql = "SELECT * FROM sqlite_master WHERE TYPE='table'";

        $data = [];
        foreach($this->sqlite->query($sql) as $table) {
            $data[] = $table['tbl_name'];
        }
        
        return $this->respond($data, __FUNCTION__);
    }
    
    /**
     * Get table data
     *
     * @param $table
     * @param bool $where
     * @param bool $limit
     * @return string
     */
    public function getTableData($table, $columns = "*", $where = false, $limit = false)
    {
        $columns = $columns ? $columns : '*';
        $sql = "SELECT ". $columns ." FROM ". $table;
    
        if ($where) {
            $sql = $sql . ' WHERE '. $where;
        }
    
        if ($limit) {
            $sql = $sql . ' LIMIT '. $limit;
        }
        
        $data = $this->sqlite->query($sql);
        return $this->respond($data, $table);
    }
    
    /**
     * Get version data
     *
     * @return string
     */
    public function getVersionData()
    {
        $sql = "SELECT * FROM app_data";
        
        $data = $this->sqlite->query($sql);
        return $this->respond($data, __FUNCTION__);
    }
    
    public function dumpAll()
    {
        $jsonOption = $this->isOptionEnabled('json_pretty') ? JSON_PRETTY_PRINT : false;
        $tables = $this->getTableList();
        
        // loop through all tables and dump everything
        foreach($tables as $table) {
            $data = $this->sqlite->query('SELECT * FROM '. $table);
            
            $folder = Config::DUMP_PATH .'/json/';
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }
            
            if ($chunkSize = $this->getOption('chunks')) {
                foreach(array_chunk($data, $chunkSize) as $i => $chunk) {
                    file_put_contents($folder . $table .'_'. $i .'.json', json_encode($chunk, $jsonOption));
                    echo "> Saved: ". $table .' '. $i ." (Size: ". $chunkSize .")\n";
                }
            } else {
                file_put_contents($folder . $table .'.json', json_encode($data, $jsonOption));
                echo "> Saved: ". $table ."\n";
            }
            
            unset($data);
        }
    }
}