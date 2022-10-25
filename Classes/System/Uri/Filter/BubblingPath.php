<?php

namespace Aoe\Asdis\System\Uri\Filter;

/**
 * Filters paths that contain "../".
 */
class BubblingPath implements FilterInterface
{
    /**
     * @param array $paths Array of paths.
     * @return array Valid paths.
     */
    public function filter(array $paths): array
    {
        $filteredPaths = [];
        foreach ($paths as $path) {
            if ($this->containsBubblingPath($path)) {
                continue;
            }
            $filteredPaths[] = $path;
        }
        return $filteredPaths;
    }

    /**
     * @param string $path
     * @return boolean
     */
    private function containsBubblingPath(string $path): bool
    {
        return strpos($path, '../') !== false;
    }
}
