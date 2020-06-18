<?php
namespace Aoe\Asdis\System\Factory\Exception;

class MissingImplementation extends \Exception
{
    /**
     * @param string $objectClassName
     * @param string $implementationClassName
     * @param string $factoryClassName
     * @param integer $code
     */
    public function __construct($objectClassName, $implementationClassName, $factoryClassName, $code)
    {
        parent::__construct(
            'Unable to create object of class "'.$objectClassName.'" in factory "'.$factoryClassName.'". '.
            'Implementation of "'.$implementationClassName.'" is missing.',
            $code
        );
    }
}