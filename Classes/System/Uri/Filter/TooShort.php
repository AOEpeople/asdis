<?php

namespace Aoe\Asdis\System\Uri\Filter;

/**
 * Filters paths which are too short.
 * @see \Aoe\Asdis\Tests\System\Uri\Filter\TooShortTest
 */
class TooShort implements FilterInterface
{
    /**
     * @var int
     */
    public const MIN_LENGTH = 5;

    /**
     * @param array $paths Array of paths.
     * @return array Valid paths.
     */
    public function filter(array $paths): array
    {
        $filteredPaths = [];
        foreach ($paths as $path) {
            if (strlen($path) < self::MIN_LENGTH) {
                continue;
            }

            $filteredPaths[] = $path;
        }

        return $filteredPaths;
    }
}
