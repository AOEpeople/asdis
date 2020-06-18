<?php
namespace Aoe\Asdis\Typo3\Hook;

use Aoe\Asdis\Typo3\Hook\AbstractHook;

class ContentPostProcAll extends AbstractHook
{
    /**
     * @param array $params
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pObj
     * @return void
     */
    public function process(&$params, \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pObj = NULL)
    {
        if($this->getConfigurationProvider()->isDefaultHookHandlingDisabled()) {
            return;
        }
        if (null === $pObj) {
            if (isset($params['pObj']) && ($params['pObj'] instanceof \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController)) {
                $pObj = $params['pObj'];
            } else {
                $pObj = $GLOBALS['TSFE'];
            }
        }
        try {
            $this->setPageObject($pObj);
            $this->scrapeAndReplace();
        } catch(\Exception $e) {
            $this->getLogger()->logException(__METHOD__, $e);
        }
    }

    /**
     * Call main process hook function only if there are no INTincScripts to include.
     * This function is called as contentPostProc-all hook.
     *
     * @param array $params
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pObj
     * @return void
     */
    public function processCache(&$params, \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pObj = null)
    {
        if ($GLOBALS['TSFE']->isINTincScript()) {
            return;
        }
        $this->process($params, $pObj);
    }

    /**
     * Call main process hook function only if there are INTincScripts to include.
     * This function is called as contentPostProc-output hook.
     * @param array $params
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pObj
     * @return void
     */
    public function processNoCache(&$params, \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pObj = null)
    {
        if (!$GLOBALS['TSFE']->isINTincScript()) {
            return;
        }
        $this->process($params, $pObj);
    }

}