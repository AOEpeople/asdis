<?php

namespace Aoe\Asdis\System\Factory\Exception;

class DeclarationNotFound extends \Exception
{
    /**
     * @param string $key
     * @param int $code
     */
    public function __construct($key, $code)
    {
        parent::__construct('No declaration with key "' . $key . '" found.', $code);
    }
}
