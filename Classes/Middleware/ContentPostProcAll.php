<?php
namespace Aoe\Asdis\Middleware;

use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Log\Logger;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class ContentPostProcAll implements MiddlewareInterface
{
    /**
     * @var \Aoe\Asdis\Domain\Model\Page
     */
    private $page;

    /**
     * @param array $params
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pObj
     * @return void
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if ($this->getConfigurationProvider()->isReplacementEnabled() === false || $this->getConfigurationProvider()->isDefaultHookHandlingDisabled()) {
            return $response;
        }

        try {
            $this->setPageObject($GLOBALS['TSFE']);
            $this->scrapeAndReplace();
            $response = new HtmlResponse($this->page->getPageObject()->content);
        } catch(\Exception $e) {
            $this->getLogger()->logException(__METHOD__, $e);
        }

        return $response;
    }

    /**
	 * @return Provider
	 */
	protected function getConfigurationProvider()
	{
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        return $objectManager->get(Provider::class);
	}

    /**
	 * @return Logger
	 */
	protected function getLogger()
	{
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        return $objectManager->get(Logger::class);
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
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var \Aoe\Asdis\Domain\Model\Page $page */
        $page = $objectManager->get(Page::class);
        $page->setAssets($objectManager->get(Collection::class));
        $page->setPageObject($pObj);
        $this->page = $page;
    }
}