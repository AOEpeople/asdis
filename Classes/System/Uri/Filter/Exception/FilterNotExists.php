<?php
namespace Aoe\Asdis\System\Uri\Filter\Exception;

/**
 * Is thrown when a requested filter does not exist.
 */
class FilterNotExists extends \Exception
{
    /**
     * @param string $filterKey
     */
    public function __construct($filterKey)
    {
        parent::__construct('Filter with the key ' . $filterKey . ' does not exist.', 1372172405389);
    }
}