<?php

/**
 * @package Tx_Asdis
 * @subpackage Api_Exception
 * @author Kevin Schu <kevin.schu@aoe.com>
 */
class Tx_Asdis_Api_Exception_NotEnabledException extends Exception
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