<?php

namespace Aoe\Asdis\Middleware;

use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Log\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use Exception;

class ContentPostProcAll implements MiddlewareInterface
{
    private ?Page $page = null;

    private Provider $provider;

    private Logger $logger;

    public function __construct(Provider $provider, Logger $logger)
    {
        $this->provider = $provider;
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if (!$this->provider->isReplacementEnabled()) {
            return $response;
        }
        if ($this->provider->isDefaultHookHandlingDisabled()) {
            return $response;
        }

        try {
            $this->setPageObject($GLOBALS['TSFE']);
            $this->scrapeAndReplace();

            //  replace response content instead init new response doesn't work well in some cases -we must do some more testing
            //$body = new Stream('php://temp', 'rw');
            //$body->write($this->page->getPageObject()->content);
            //$response->withBody($body);
            $response = new HtmlResponse($this->page->getPageObject()->content);
        } catch (Exception $exception) {
            $this->logger
                ->logException(__METHOD__, $exception);
        }

        return $response;
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
        $page = GeneralUtility::makeInstance(Page::class);
        $page->setAssets(GeneralUtility::makeInstance(Collection::class));
        $page->setPageObject($pObj);
        $this->page = $page;
    }
}
