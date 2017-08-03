<?php

namespace Libra;

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
        return $this->respond($data, __FUNCTION__);
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
}