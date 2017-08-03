<?php

namespace Libra\Exceptions;

/**
 * Class SqliteConnectionFailedException
 *
 * @package Libra\Exceptions
 */
class SqliteQueryFailedException extends \Exception
{
    const ERROR = 'Could not perform query against sqlite file';
    
    /**
     * SqliteConnectionFailedException constructor.
     *
     * @param null|\Exception $ex
     */
    public function __construct($ex = null)
    {
        $message = self::ERROR;
        
        if ($ex) {
            $message = $message .': '. $ex->getMessage();
        }
        
        parent::__construct($message, 500, $ex);
    }
}