<?php
namespace Aoe\Asdis\Domain\Model;

use Aoe\Asdis\Content\Replacement\Processor;
use Aoe\Asdis\Content\Scraper\ChainFactory;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\DistributionAlgorithm\Factory;
use Aoe\Asdis\Domain\Repository\ServerRepository;
use Aoe\Asdis\System\Configuration\Provider;

/**
 * Represents a page in the TYPO3 page tree.
 */
class Page
{
    /**
     * @var \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    private $assets;

    /**
     * @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    private $pageObject;

    /**
     * @var \Aoe\Asdis\Content\Scraper\ChainFactory
     */
    private $scraperChainFactory;

    /**
     * @var \Aoe\Asdis\Domain\Model\DistributionAlgorithm\Factory
     */
    private $distributionAlgorithmFactory;

    /**
     * @var \Aoe\Asdis\Domain\Repository\ServerRepository
     */
    private $serverRepository;

    /**
     * @var \Aoe\Asdis\System\Configuration\Provider
     */
    private $configurationProvider;

    /**
     * @var \Aoe\Asdis\Content\Replacement\Processor
     */
    private $replacementProcessor;

    /**
     * @param \Aoe\Asdis\Content\Scraper\ChainFactory $scraperChainFactory
     */
    public function injectScraperChainFactory(ChainFactory $scraperChainFactory)
    {
        $this->scraperChainFactory = $scraperChainFactory;
    }

    /**
     * @param \Aoe\Asdis\Domain\Model\DistributionAlgorithm\Factory $distributionAlgorithmFactory
     */
    public function injectDistributionAlgorithmFactory(Factory $distributionAlgorithmFactory)
    {
        $this->distributionAlgorithmFactory = $distributionAlgorithmFactory;
    }

    /**
     * @param \Aoe\Asdis\Domain\Repository\ServerRepository $serverRepository
     */
    public function injectServerRepository(ServerRepository $serverRepository)
    {
        $this->serverRepository = $serverRepository;
    }

    /**
     * @param \Aoe\Asdis\System\Configuration\Provider $configurationProvider
     */
    public function injectConfigurationProvider(Provider $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }

    /**
     * @param \Aoe\Asdis\Content\Replacement\Processor $replacementProcessor
     */
    public function injectReplacementProcessor(Processor $replacementProcessor)
    {
        $this->replacementProcessor = $replacementProcessor;
    }

    /**
     * Scrapes the assets of the page. There is no replacement taking place. You have to call "replaceAssets" to replace
     * the paths after calling "scrapeAssets".
     *
     * @return void
     */
    public function scrapeAssets()
    {
        if (false === $this->configurationProvider->isReplacementEnabled()) {
            return;
        }
        $this->setAssets($this->scraperChainFactory->buildChain()->scrape($this->pageObject->content));
    }

    /**
     * Replaces the assets of the page.
     * To force any replacement, you have to call "scrapeAssets" before.
     *
     * @return void
     */
    public function replaceAssets()
    {
        if (false === $this->configurationProvider->isReplacementEnabled()) {
            return;
        }
        $distributionAlgorithmKey = '';
        try {
            $distributionAlgorithmKey = $this->configurationProvider->getDistributionAlgorithmKey();
        } catch(\Exception $e) {}
        $distributionAlgorithm = $this->distributionAlgorithmFactory->buildDistributionAlgorithmFromKey($distributionAlgorithmKey);
        $distributionAlgorithm->distribute($this->getAssets(), $this->serverRepository->findAllByPage($this));
        $this->pageObject->content = $this->replacementProcessor->replace(
            $this->assets->getReplacementMap(),
            $this->pageObject->content
        );
    }

    /**
     * @param \Aoe\Asdis\Domain\Model\Asset\Collection $assets
     */
    public function setAssets(Collection $assets)
    {
        $this->assets = $assets;
    }

    /**
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pageObject
     */
    public function setPageObject(\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pageObject)
    {
        $this->pageObject = $pageObject;
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    public function getPageObject()
    {
        return $this->pageObject;
    }

    /**
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    public function getAssets()
    {
        return $this->assets;
    }
}