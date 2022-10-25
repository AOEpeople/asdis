<?php

namespace Aoe\Asdis\System\Uri\Filter;

/**
 * Filters paths that start with "data:".
 */
class ContainsInlineData implements FilterInterface
{
    /**
     * @param array $paths Array of paths.
     * @return array Valid paths.
     */
    public function filter(array $paths): array
    {
        $filteredPaths = [];
        foreach ($paths as $path) {
            if (strpos($path, 'data:') === 0) {
                continue;
            }
            $filteredPaths[] = $path;
        }
        return $filteredPaths;
    }
}
