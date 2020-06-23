<?php
namespace Aoe\Asdis\Api\Exception;

class NotEnabledException extends Exception
{
    /**
     * @param integer $code
     * @param Exception|null $previous
     */
    public function __construct($code = 0, Exception $previous = null)
    {
        parent::__construct('asdis is not enabled at the moment', $code, $previous);
    }
}