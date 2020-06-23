<?php
namespace Aoe\Asdis\Content\Replacement;

use Aoe\Asdis\Content\Replacement\Map;

/**
 * Replaces content.
 */
class Processor
{
    /**
     * @param \Aoe\Asdis\Content\Replacement\Map $replacementMap
     * @param string $content
     * @return string
     */
    public function replace(Map $replacementMap, $content)
    {
        $result = preg_replace(
            $replacementMap->getSources(),
            $replacementMap->getTargets(),
            $content
        );
        if (null === $result) {
            return $content;
        }
        return $result;
    }
}