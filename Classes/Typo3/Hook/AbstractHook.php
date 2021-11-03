<?php
namespace Aoe\Asdis\Typo3\Hook;

use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Log\Logger;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Abstract hook class.
 */
abstract class AbstractHook
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var \Aoe\Asdis\System\Log\Logger
     */
    private $logger;

    /**
     * @var \Aoe\Asdis\Domain\Model\Page
     */
    private $page;

    /**
     * @var \Aoe\Asdis\System\Configuration\Provider
     */
    private $configurationProvider;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->configurationProvider = $this->objectManager->get(Provider::class);
        $this->logger = $this->objectManager->get(Logger::class);
    }

    /**
     * @return \Aoe\Asdis\System\Configuration\Provider
     */
    protected function getConfigurationProvider()
    {
        return $this->configurationProvider;
    }

    /**
     * @return \Aoe\Asdis\System\Log\Logger
     */
    protected function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return void
     */
    protected function scrapeAssets()
    {
        $this->page->scrapeAssets();
    }

    /**
     * @return void
     */
    protected function replaceAssets()
    {
        $this->page->replaceAssets();
    }

    /**
     * Scrapes and replaces the assets of the current page.
     *
     * @return void
     */
    protected function scrapeAndReplace()
    {
        $this->scrapeAssets();
        $this->replaceAssets();
    }

    /**
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pObj
     */
    protected function setPageObject(\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pObj)
    {
        /** @var Page $page */
        $page = $this->objectManager->get(Page::class);
        $page->setAssets($this->objectManager->get(Collection::class));
        $page->setPageObject($pObj);
        $this->page = $page;
    }
}