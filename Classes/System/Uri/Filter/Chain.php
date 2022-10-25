<?php

namespace Aoe\Asdis\System\Uri\Filter;

/**
 * Chain of filters.
 */
class Chain extends \ArrayIterator implements FilterInterface
{
    /**
     * Needs to be called due to an extbase bug.
     * Hides optional parameters of parent constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param \Aoe\Asdis\System\Uri\Filter\FilterInterface $filter
     */
    public function append($filter)
    {
        parent::append($filter);
    }

    /**
     * @param array $paths Array of paths.
     * @return array Valid paths.
     */
    public function filter(array $paths): array
    {
        if ($this->count() < 1) {
            return $paths;
        }
        foreach ($this as $filter) {
            /** @var \Aoe\Asdis\System\Uri\Filter\FilterInterface $filter */
            $paths = $filter->filter($paths);
        }
        return $paths;
    }
}
