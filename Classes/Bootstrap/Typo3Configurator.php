<?php

declare(strict_types=1);

namespace Aoe\Asdis\Bootstrap;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\TypoScriptAspect;
use TYPO3\CMS\Core\Core\Event\BootCompletedEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

class Typo3Configurator
{
    public function forceTemplateParsingInFrontend(BootCompletedEvent $event): void
    {
        if (version_compare(VersionNumberUtility::getCurrentTypo3Version(), '12.4.0', '>')) {
            /**
             * We must force templateParsing - otherwise the TypoScript (which configures this
             * extension) is not available in the frontend, so we can't get the TypoScript here:
             * @see \Aoe\Asdis\System\Configuration\TypoScriptConfiguration::getTypoScriptConfigurationArray
             */
            $context = GeneralUtility::makeInstance(Context::class);
            $context->setAspect('typoscript', GeneralUtility::makeInstance(TypoScriptAspect::class, true));
        }
    }
}
