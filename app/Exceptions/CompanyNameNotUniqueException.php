<?php


namespace App;

class CompanyNameNotUniqueException extends \Exception
{
    /**
     * CompanyNameNotUniqueException constructor.
     * @param string $message
     * @param int $code
     * @param null $previous
     */
    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
