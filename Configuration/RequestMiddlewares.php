<?php

$rearrangedMiddlewares = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    TYPO3\CMS\Core\Configuration\Features::class
)->isFeatureEnabled('rearrangedRedirectMiddlewares');

return [
    'frontend' => [
        'aoe/asdis/contentPostProc/all' => [
            'target' => \Aoe\Asdis\Middleware\ContentPostProcAll::class,
            'before' => [
                'typo3/cms-frontend/content-length-headers'
            ],
            'after' => [
                'typo3/cms-frontend/prepare-tsfe-rendering',
            ],
        ],
    ],
];
