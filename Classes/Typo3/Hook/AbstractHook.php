<?php

namespace Aoe\Asdis\Typo3\Hook;

use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Log\Logger;
use RectorPrefix20210613\TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Abstract hook class.
 */
abstract class AbstractHook
{
    private ObjectManagerInterface $objectManager;

    private Logger $logger;

    private Page $page;

    private Provider $configurationProvider;

    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->configurationProvider = $this->objectManager->get(Provider::class);
        $this->logger = $this->objectManager->get(Logger::class);
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
        $page = $this->objectManager->get(Page::class);
        $page->setAssets($this->objectManager->get(Collection::class));
        $page->setPageObject($pObj);
        $this->page = $page;
    }
}
