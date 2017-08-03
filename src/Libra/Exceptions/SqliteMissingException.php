<?php

namespace Libra\Exceptions;

/**
 * Class SqliteMissingException
 *
 * @package Libra\Exceptions
 */
class SqliteMissingException extends \Exception
{
    const ERROR = 'Sqlite file missing from the db directory';
    
    /**
     * SqliteMissingException constructor.
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