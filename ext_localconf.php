<?php

defined('TYPO3_MODE') or die();

call_user_func(
    static function () {
        if (extension_loaded('newrelic')) {
            $configuration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
            )->get('newrelic_integration');

            if (!empty($GLOBALS['argv'])) {
                newrelic_name_transaction('CLI/command/' . $GLOBALS['argv'][1] . (isset($GLOBALS['argv'][2]) ? '/' . $GLOBALS['argv'][2] : ''));
            } else {
                newrelic_name_transaction(TYPO3_MODE);
            }

            newrelic_capture_params(true);

            if ($configuration['traceObjectInstancing']) {
                newrelic_add_custom_tracer(\TYPO3\CMS\Core\Utility\GeneralUtility::class . '::makeInstance');
                newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Object\ObjectManager::class . '::get');
            }

            if ($configuration['traceFluidParsing']) {
                newrelic_add_custom_tracer(\TYPO3Fluid\Fluid\Core\Parser\TemplateParser::class . '::parse');
            }

            if ($configuration['traceFluidRendering']) {
                newrelic_add_custom_tracer(\TYPO3Fluid\Fluid\View\TemplateView::class . '::render');
                newrelic_add_custom_tracer(\TYPO3Fluid\Fluid\View\TemplateView::class . '::renderPartial');
                newrelic_add_custom_tracer(\TYPO3Fluid\Fluid\View\TemplateView::class . '::renderSection');
            }

            if ($configuration['traceExtbaseControllers']) {
                newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Mvc\Controller\ActionController::class . '::processRequest');
                newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Mvc\Controller\ActionController::class . '::initializeAction');
                newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Mvc\Controller\ActionController::class . '::callActionMethod');
            }

            if ($configuration['traceExtbasePersistence']) {
                newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Persistence\Generic\Query::class . '::execute');
                newrelic_add_custom_tracer(\TYPO3\CMS\Extbase\Property\PropertyMapper::class . '::convert');
            }

            if ($configuration['traceCacheOperations']) {
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
                newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\PdoBackend::class . '::get');
                newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\PdoBackend::class . '::set');
                newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\PdoBackend::class . '::flush');
                newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\PdoBackend::class . '::flushByTags');
                newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\WincacheBackend::class . '::get');
                newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\WincacheBackend::class . '::set');
                newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\WincacheBackend::class . '::flush');
                newrelic_add_custom_tracer(\TYPO3\CMS\Core\Cache\Backend\WincacheBackend::class . '::flushByTags');
            }

            if (TYPO3_MODE === 'BE') {
                if ($configuration['traceDataHandlerCommands']) {
                    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = \NamelessCoder\NewrelicIntegration\Hooks\DataHandlerHookSubscriber::class;
                }

                $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawFooterHook']['newrelic_integration'] = function (
                    array $parameters,
                    \TYPO3\CMS\Backend\Controller\PageLayoutController $pageLayoutController
                ) {
                    newrelic_name_transaction('BE/' . $pageLayoutController->MCONF['name']);
                };
            }

            if (TYPO3_MODE === 'FE') {
                if ($configuration['traceTypoScriptParsing']) {
                    newrelic_add_custom_tracer(\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser::class . '::parse');
                    newrelic_add_custom_tracer(\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser::class . '::includeFile');
                    newrelic_add_custom_tracer(\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser::class . '::includeDirectory');
                }

                if ($configuration['tracePageUid']) {
                    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['determineId-PostProc']['newrelic'] = function (
                        array $parameters,
                        \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $controller
                    ) use ($configuration) {
                        newrelic_name_transaction(TYPO3_MODE . '/page-' . $controller->id . '-default');
                        if ($configuration['tracePageType']) {
                            if (\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('type')) {
                                newrelic_name_transaction(TYPO3_MODE . '/page-' . $controller->id . '-type' . \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('type'));
                            }
                        }
                    };
                }

                if ($configuration['traceFrontendUsers']) {
                    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['initFEuser']['newrelic'] = function (
                        array $parameters,
                        \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $controller
                    ) {
                        $login = $controller->fe_user->getLoginFormData();
                        if (!empty($login) && $login['status'] === 'login') {
                            newrelic_name_transaction('FE login');
                        }
                        if (empty($controller->fe_user->user['uid'])) {
                            newrelic_add_custom_parameter('Frontend user', 'Anonymous');
                        } else {
                            // Fetch current field configuration, default back to default fields if ext-conf is not set yet
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
        }
    }
);
