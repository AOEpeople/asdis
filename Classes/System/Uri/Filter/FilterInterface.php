<?php

namespace Aoe\Asdis\System\Uri\Filter;

/**
 * URI filter interface.
 */
interface FilterInterface
{
    /**
     * @param array $paths Array of paths.
     * @return array Valid paths.
     */
    public function filter(array $paths): array;
}
