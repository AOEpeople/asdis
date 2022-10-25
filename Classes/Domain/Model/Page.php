<?php

namespace Aoe\Asdis\Domain\Model;

use Aoe\Asdis\Content\Replacement\Processor;
use Aoe\Asdis\Content\Scraper\ChainFactory;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\DistributionAlgorithm\Factory;
use Aoe\Asdis\Domain\Repository\ServerRepository;
use Aoe\Asdis\System\Configuration\Provider;
use Exception;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Represents a page in the TYPO3 page tree.
 */
class Page
{
    /**
     * @var Collection
     */
    private $assets;

    /**
     * @var TypoScriptFrontendController
     */
    private $pageObject;

    /**
     * @var ChainFactory
     */
    private $scraperChainFactory;

    /**
     * @var Factory
     */
    private $distributionAlgorithmFactory;

    /**
     * @var ServerRepository
     */
    private $serverRepository;

    /**
     * @var Provider
     */
    private $configurationProvider;

    /**
     * @var Processor
     */
    private $replacementProcessor;

    /**
     * @param ChainFactory $scraperChainFactory
     */
    public function injectScraperChainFactory(ChainFactory $scraperChainFactory)
    {
        $this->scraperChainFactory = $scraperChainFactory;
    }

    /**
     * @param Factory $distributionAlgorithmFactory
     */
    public function injectDistributionAlgorithmFactory(Factory $distributionAlgorithmFactory)
    {
        $this->distributionAlgorithmFactory = $distributionAlgorithmFactory;
    }

    /**
     * @param ServerRepository $serverRepository
     */
    public function injectServerRepository(ServerRepository $serverRepository)
    {
        $this->serverRepository = $serverRepository;
    }

    /**
     * @param Provider $configurationProvider
     */
    public function injectConfigurationProvider(Provider $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }

    /**
     * @param Processor $replacementProcessor
     */
    public function injectReplacementProcessor(Processor $replacementProcessor)
    {
        $this->replacementProcessor = $replacementProcessor;
    }

    /**
     * Scrapes the assets of the page. There is no replacement taking place. You have to call "replaceAssets" to replace
     * the paths after calling "scrapeAssets".
     */
    public function scrapeAssets()
    {
        if ($this->configurationProvider->isReplacementEnabled() === false) {
            return;
        }
        $this->setAssets($this->scraperChainFactory->buildChain()->scrape($this->pageObject->content));
    }

    /**
     * Replaces the assets of the page.
     * To force any replacement, you have to call "scrapeAssets" before.
     */
    public function replaceAssets()
    {
        if ($this->configurationProvider->isReplacementEnabled() === false) {
            return;
        }
        $distributionAlgorithmKey = '';
        try {
            $distributionAlgorithmKey = $this->configurationProvider->getDistributionAlgorithmKey();
        } catch (Exception $e) {
        }
        $distributionAlgorithm = $this->distributionAlgorithmFactory->buildDistributionAlgorithmFromKey($distributionAlgorithmKey);
        $distributionAlgorithm->distribute($this->getAssets(), $this->serverRepository->findAllByPage($this));
        $this->pageObject->content = $this->replacementProcessor->replace(
            $this->assets->getReplacementMap(),
            $this->pageObject->content
        );
    }

    /**
     * @param Collection $assets
     */
    public function setAssets(Collection $assets)
    {
        $this->assets = $assets;
    }

    /**
     * @param TypoScriptFrontendController $pageObject
     */
    public function setPageObject(TypoScriptFrontendController $pageObject)
    {
        $this->pageObject = $pageObject;
    }

    /**
     * @return TypoScriptFrontendController
     */
    public function getPageObject()
    {
        return $this->pageObject;
    }

    /**
     * @return Collection
     */
    public function getAssets()
    {
        return $this->assets;
    }
}
