<?php

namespace Aoe\Asdis\Typo3\Hook;

use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Log\Logger;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Abstract hook class.
 */
abstract class AbstractHook
{
    private Logger $logger;

    private Page $page;

    private Provider $configurationProvider;

    public function __construct()
    {
        $this->configurationProvider = GeneralUtility::makeInstance(Provider::class);
        $this->logger = GeneralUtility::makeInstance(Logger::class);
    }

    protected function getConfigurationProvider(): Provider
    {
        return $this->configurationProvider;
    }

    protected function getLogger(): Logger
    {
        return $this->logger;
    }

    protected function scrapeAssets(): void
    {
        $this->page->scrapeAssets();
    }

    protected function replaceAssets(): void
    {
        $this->page->replaceAssets();
    }

    /**
     * Scrapes and replaces the assets of the current page.
     */
    protected function scrapeAndReplace(): void
    {
        $this->scrapeAssets();
        $this->replaceAssets();
    }

    protected function setPageObject(TypoScriptFrontendController $pObj): void
    {
        /** @var Page $page */
        $page = GeneralUtility::makeInstance(Page::class);
        $page->setAssets(GeneralUtility::makeInstance(Collection::class));
        $page->setPageObject($pObj);
        $this->page = $page;
    }
}
