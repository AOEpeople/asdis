<?php

namespace Aoe\Asdis\Middleware;

use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Log\Logger;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

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

        $header = $response->getHeaders();
        $status = $response->getStatusCode();

        try {
            $this->setPageObject($this->getTsfe());
            $this->scrapeAndReplace();

            $header['Content-Length'] = strlen($this->page->getPageObject()->content);
            $response = new HtmlResponse($this->page->getPageObject()->content, $status, $header);
        } catch (Exception $exception) {
            $this->logger
                ->logException(__METHOD__, $exception);
        }

        return $response;
    }

    protected function getTsfe(): TypoScriptFrontendController
    {
        /** @var ServerRequestInterface $typo3Request */
        $typo3Request = $GLOBALS['TYPO3_REQUEST'];
        return $typo3Request->getAttribute('frontend.controller');
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
