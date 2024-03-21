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
 * @see \Aoe\Asdis\Tests\Domain\Model\PageTest
 */
class Page
{
    private ?Collection $assets = null;

    private ?TypoScriptFrontendController $pageObject = null;

    private ?ChainFactory $scraperChainFactory = null;

    private ?Factory $distributionAlgorithmFactory = null;

    private ?ServerRepository $serverRepository = null;

    private ?Provider $configurationProvider = null;

    private ?Processor $replacementProcessor = null;

    public function __construct(Provider $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }

    public function injectScraperChainFactory(ChainFactory $scraperChainFactory): void
    {
        $this->scraperChainFactory = $scraperChainFactory;
    }

    public function injectDistributionAlgorithmFactory(Factory $distributionAlgorithmFactory): void
    {
        $this->distributionAlgorithmFactory = $distributionAlgorithmFactory;
    }

    public function injectServerRepository(ServerRepository $serverRepository): void
    {
        $this->serverRepository = $serverRepository;
    }

    public function injectReplacementProcessor(Processor $replacementProcessor): void
    {
        $this->replacementProcessor = $replacementProcessor;
    }

    /**
     * Scrapes the assets of the page. There is no replacement taking place. You have to call "replaceAssets" to replace
     * the paths after calling "scrapeAssets".
     */
    public function scrapeAssets(): void
    {
        if (!$this->configurationProvider->isReplacementEnabled()) {
            return;
        }

        $this->setAssets($this->scraperChainFactory->buildChain()->scrape($this->pageObject->content));
    }

    /**
     * Replaces the assets of the page.
     * To force any replacement, you have to call "scrapeAssets" before.
     */
    public function replaceAssets(): void
    {
        if (!$this->configurationProvider->isReplacementEnabled()) {
            return;
        }

        $distributionAlgorithmKey = '';
        try {
            $distributionAlgorithmKey = $this->configurationProvider->getDistributionAlgorithmKey();
        } catch (Exception $exception) {
        }

        $distributionAlgorithm = $this->distributionAlgorithmFactory->buildDistributionAlgorithmFromKey($distributionAlgorithmKey);
        $distributionAlgorithm->distribute($this->assets, $this->serverRepository->findAllByPage($this));

        $this->pageObject->content = $this->replacementProcessor->replace(
            $this->assets->getReplacementMap(),
            $this->pageObject->content
        );
    }

    public function setAssets(Collection $assets): void
    {
        $this->assets = $assets;
    }

    public function setPageObject(TypoScriptFrontendController $pageObject): void
    {
        $this->pageObject = $pageObject;
    }

    public function getPageObject(): ?TypoScriptFrontendController
    {
        return $this->pageObject;
    }

    public function getAssets(): ?Collection
    {
        return $this->assets;
    }
}
