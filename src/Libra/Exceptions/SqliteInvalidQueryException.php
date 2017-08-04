<?php

namespace Libra\Exceptions;

/**
 * Class SqliteInvalidQueryException
 *
 * @package Libra\Exceptions
 */
class SqliteInvalidQueryException extends \Exception
{
    const ERROR = 'SQL query could not be prepared, possibly invalid';
    
    /**
     * SqliteInvalidQueryException constructor.
     *
     * @param null $ex
     * @param null $message
     */
    public function __construct($ex = null, $extra = null)
    {
        $message = self::ERROR;
        
        if ($ex ||  $extra) {
            $message = $message .': '. $extra ? $extra : $ex->getMessage();
        }
        
        parent::__construct($message, 500, $ex);
    }
}