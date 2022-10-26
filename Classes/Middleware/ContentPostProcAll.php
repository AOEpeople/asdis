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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use Exception;

class ContentPostProcAll implements MiddlewareInterface
{
    private ?Page $page = null;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if (!$this->getConfigurationProvider()->isReplacementEnabled()) {
            return $response;
        }
        if ($this->getConfigurationProvider()->isDefaultHookHandlingDisabled()) {
            return $response;
        }

        try {
            $this->setPageObject($GLOBALS['TSFE']);
            $this->scrapeAndReplace();
            $response = new HtmlResponse($this->page->getPageObject()->content);
        } catch (Exception $exception) {
            $this->getLogger()
                ->logException(__METHOD__, $exception);
        }

        return $response;
    }

    protected function getConfigurationProvider(): Provider
    {
        return GeneralUtility::makeInstance(Provider::class);
    }

    protected function getLogger(): Logger
    {
        return GeneralUtility::makeInstance(Logger::class);
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
