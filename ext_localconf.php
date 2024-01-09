<?php

defined('TYPO3_MODE') || defined('TYPO3') or die();

(static function() {
    if (!extension_loaded('newrelic')) {
        return;
    }

    $applicationType = 'BE';
    if (defined('TYPO3_MODE')) {
        $applicationType = TYPO3_MODE;
    } elseif (($GLOBALS['TYPO3_REQUEST'] ?? null) instanceof \Psr\Http\Message\ServerRequestInterface) {
        $applicationType = \TYPO3\CMS\Core\Http\ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->abbreviate();
    }

    if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['newrelic_integration']) && version_compare(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getExtensionVersion('core'), '9.5', '>')) {
        // Import settings that exist in serialized arrays. These override settings that would otherwise be stored in the new
        // raw array. Once settings have been saved by install tool "Settings" module, the old serialized value is removed from
        // the array and this condition will no longer trigger.
        $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['newrelic_integration'] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['newrelic_integration']);
    }
    $configuration = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['newrelic_integration'] ?? [];

    if (!empty($GLOBALS['argv'])) {
        newrelic_name_transaction('CLI/command/' . $GLOBALS['argv'][1] . (isset($GLOBALS['argv'][2]) ? '/' . $GLOBALS['argv'][2] : ''));
    } else {
        newrelic_name_transaction($applicationType);
    }

    newrelic_capture_params(true);

    if (isset($configuration['traceObjectInstancing']) && $configuration['traceObjectInstancing']) {
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Utility\GeneralUtility::class . '::makeInstance');
        if (class_exists(\TYPO3\CMS\Extbase\Object\ObjectManager::class)) {
            newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Object\ObjectManager::class . '::get');
        }
    }

    if (isset($configuration['traceFluidParsing']) && $configuration['traceFluidParsing']) {
        newrelic_add_custom_tracer(\TYPO3Fluid\Fluid\Core\Parser\TemplateParser::class . '::parse');
    }

    if (isset($configuration['traceFluidRendering']) && $configuration['traceFluidRendering']) {
        newrelic_add_custom_tracer(\TYPO3Fluid\Fluid\View\TemplateView::class . '::render');
        newrelic_add_custom_tracer(\TYPO3Fluid\Fluid\View\TemplateView::class . '::renderPartial');
        newrelic_add_custom_tracer(\TYPO3Fluid\Fluid\View\TemplateView::class . '::renderSection');
    }

    if (isset($configuration['traceExtbaseControllers']) && $configuration['traceExtbaseControllers']) {
        newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Mvc\Controller\ActionController::class . '::processRequest');
        newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Mvc\Controller\ActionController::class . '::initializeAction');
        newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Mvc\Controller\ActionController::class . '::callActionMethod');
    }

    if (isset($configuration['traceExtbasePersistence']) && $configuration['traceExtbasePersistence']) {
        newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Persistence\Generic\Query::class . '::execute');
        newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Property\PropertyMapper::class . '::convert');
    }

    if (isset($configuration['traceCacheOperations']) && $configuration['traceCacheOperations']) {
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class . '::get');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class . '::set');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class . '::flush');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class . '::flushByTags');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class . '::get');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class . '::set');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class . '::flush');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\FileBackend::class . '::get');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\FileBackend::class . '::set');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\FileBackend::class . '::flush');
        if (class_exists(\TYPO3\CMS\Core\Cache\Backend\ApcBackend::class)) {
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\ApcBackend::class . '::get');
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\ApcBackend::class . '::set');
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\ApcBackend::class . '::flush');
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\ApcBackend::class . '::flushByTags');
        }
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\ApcuBackend::class . '::get');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\ApcuBackend::class . '::set');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\ApcuBackend::class . '::flush');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\ApcuBackend::class . '::flushByTags');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\MemcachedBackend::class . '::get');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\MemcachedBackend::class . '::set');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\MemcachedBackend::class . '::flush');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\MemcachedBackend::class . '::flushByTags');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\NullBackend::class . '::get');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\NullBackend::class . '::set');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend::class . '::get');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend::class . '::set');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend::class . '::flush');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend::class . '::flushByTags');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\RedisBackend::class . '::get');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\RedisBackend::class . '::set');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\RedisBackend::class . '::flush');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\RedisBackend::class . '::flushByTags');
        if (class_exists(\TYPO3\CMS\Core\Cache\Backend\PdoBackend::class)) {
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\PdoBackend::class . '::get');
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\PdoBackend::class . '::set');
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\PdoBackend::class . '::flush');
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\PdoBackend::class . '::flushByTags');
        }
        if (class_exists(\TYPO3\CMS\Core\Cache\Backend\WincacheBackend::class)) {
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\WincacheBackend::class . '::get');
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\WincacheBackend::class . '::set');
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\WincacheBackend::class . '::flush');
            newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\WincacheBackend::class . '::flushByTags');
        }
    }

    if (isset($configuration['traceDataHandlerCommands']) && $configuration['traceDataHandlerCommands']) {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][]
            = \NamelessCoder\NewrelicIntegration\Hooks\DataHandlerHookSubscriber::class;
    }

    if (isset($configuration['traceTypoScriptParsing']) && $configuration['traceTypoScriptParsing']) {
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser::class . '::parse');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser::class . '::includeFile');
        newrelic_add_custom_tracer(\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser::class . '::includeDirectory');
    }

    if (version_compare(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getExtensionVersion('core'), '12.0', '<')) {
        /*
         * Since there is no constant for the 'web_layout' module name, use it directly.
         * Up to TYPO3 v10, it was possible to use $pageLayoutController->MCONF['name']
         */
        /** In TYPO3 v12.0, this hook has been replaced by a PSR-14 event */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawFooterHook']['newrelic_integration'] = static function() {
            newrelic_name_transaction('BE/web_layout');
        };

        /** In TYPO3 v12.0, this hook has been replaced by a PSR-14 event */
        if (isset($configuration['tracePageUid']) && $configuration['tracePageUid']) {
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['determineId-PostProc']['newrelic'] = static function(
                array $parameters,
                \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $controller
            ) use ($configuration, $applicationType) {

                newrelic_name_transaction($applicationType . '/page-' . $controller->id . '-default');
                if (isset($configuration['tracePageType']) && $configuration['tracePageType']) {
                    if (\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('type') ?? null) {
                        newrelic_name_transaction(
                            $applicationType . '/page-' . $controller->id . '-type' . \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
                                'type'
                            )
                        );
                    }
                }
            };
        }
    }

    if (version_compare(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getExtensionVersion('core'), '9.5', '<')) {
        /** In TYPO3 v9.5, this hook has been deprecated and replaced by a PSR-15 middleware */
        if (isset($configuration['traceFrontendUsers']) && $configuration['traceFrontendUsers']) {
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['initFEuser']['newrelic'] = static function(
                array $parameters,
                \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $controller
            ) use ($configuration) {
                $login = $controller->fe_user->getLoginFormData();
                if (!empty($login) && $login['status'] === 'login') {
                    newrelic_name_transaction('FE login');
                }
                if (empty($controller->fe_user->user['uid'])) {
                    newrelic_add_custom_parameter('Frontend user', 'Anonymous');
                } else {
                    $traceFrontendUsersFields = !empty($configuration['traceFrontendUsersFields']) ? \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $configuration['traceFrontendUsersFields']) : ['uid', 'username', 'company', 'email'];
                    $traceFields = [];
                    foreach ($traceFrontendUsersFields as $traceFrontendUsersField) {
                        $traceFields[] = $controller->fe_user->user[$traceFrontendUsersField];
                    }

                    newrelic_add_custom_parameter(
                        'Frontend user',
                        implode(
                            ', ',
                            $traceFields
                        )
                    );
                }
            };
        }
    }
})();
