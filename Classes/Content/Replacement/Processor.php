<?php

namespace Aoe\Asdis\Content\Replacement;

/**
 * Replaces content.
 */
class Processor
{
    /**
     * @param Map $replacementMap
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
        if ($result === null) {
            return $content;
        }
        return $result;
    }
}
