<?php

namespace Aoe\Asdis\Content\Replacement;

/**
 * Replaces content.
 * @see \Aoe\Asdis\Tests\Content\Replacement\ProcessorTest
 */
class Processor
{
    public function replace(Map $replacementMap, string $content): string
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
