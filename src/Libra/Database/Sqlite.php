<?php

namespace Libra\Database;

use Libra\App\Config;
use Libra\Exceptions\{
    SqliteConnectionFailedException, SqliteInvalidQueryException, SqliteMissingException, SqliteQueryFailedException
};

/**
 * Class Sqlite
 *
 * @package Libra\Database
 */
class Sqlite
{
    /** @var \PDO */
    private $instance;

    /**
     * Sqlite constructor.
     *
     * Connects to the sqlite file
     *
     * @param $sqliteFile
     * @throws SqliteConnectionFailedException
     * @throws SqliteMissingException
     */
    function __construct($sqliteFile)
    {
        if (!file_exists($sqliteFile)) {
            throw new SqliteMissingException();
        }

        try {
            // connect to sqlite file
            $this->instance = new \PDO('sqlite:'. $sqliteFile);

            // connection failed
            if (!$this->instance) {
                throw new SqliteConnectionFailedException();
            }
        } catch (\PDOException $ex) {
            throw new SqliteConnectionFailedException($ex);
        }
    }
    
    /**
     * Run an SQL Query
     *
     * @param $sql
     * @return array
     * @throws SqliteQueryFailedException
     */
    public function query($sql)
    {
        try {
            // run query
            $query = $this->instance->prepare($sql);
            
            if (!$query) {
                throw new SqliteInvalidQueryException(null, $sql);
            }
            $query->execute();
    
            $results = [];
            foreach($query->fetchAll(\PDO::FETCH_ASSOC) as $i => $result) {
                foreach($result as $column => $value) {
                    if ($value && $value[0] == '{') {
                        $value = json_decode($value, true);
                    }
                    
                    $result[$column] = $value;
                }
                
                $results[$i] = $result;
            }
            
            // return all results
            return $results;
        } catch (\PDOException $ex) {
            throw new SqliteQueryFailedException($ex);
        }
    }
}