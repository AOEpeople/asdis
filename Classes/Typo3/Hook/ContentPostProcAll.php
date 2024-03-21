<?php

namespace Aoe\Asdis\Typo3\Hook;

use Exception;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class ContentPostProcAll extends AbstractHook
{
    public function process(array &$params, TypoScriptFrontendController $pObj = null): void
    {
        if ($this->getConfigurationProvider()->isDefaultHookHandlingDisabled()) {
            return;
        }

        if ($pObj === null) {
            if (isset($params['pObj']) && ($params['pObj'] instanceof TypoScriptFrontendController)) {
                $pObj = $params['pObj'];
            } else {
                $pObj = $GLOBALS['TSFE'];
            }
        }

        try {
            $this->setPageObject($pObj);
            $this->scrapeAndReplace();
        } catch (Exception $exception) {
            $this->getLogger()
                ->logException(__METHOD__, $exception);
        }
    }

    /**
     * Call main process hook function only if there are no INTincScripts to include.
     * This function is called as contentPostProc-all hook.
     */
    public function processCache(array &$params, TypoScriptFrontendController $pObj = null): void
    {
        if ($GLOBALS['TSFE']->isINTincScript()) {
            return;
        }

        $this->process($params, $pObj);
    }

    /**
     * Call main process hook function only if there are INTincScripts to include.
     * This function is called as contentPostProc-output hook.
     */
    public function processNoCache(array &$params, TypoScriptFrontendController $pObj = null): void
    {
        if (!$GLOBALS['TSFE']->isINTincScript()) {
            return;
        }

        $this->process($params, $pObj);
    }
}
