<?php

declare(strict_types=1);

namespace NamelessCoder\NewrelicIntegration\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class FrontendUserAuthenticator implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!extension_loaded('newrelic')) {
            return $handler->handle($request);
        }

        if ($GLOBALS['TSFE'] instanceof TypoScriptFrontendController) {
            $this->processFrontendLogin($request);
        }

        return $handler->handle($request);
    }

    protected function processFrontendLogin(ServerRequestInterface $request)
    {
        $login = $GLOBALS['TSFE']->fe_user->getLoginFormData($request);
        if (isset($login['status']) && $login['status'] === 'login') {
            newrelic_name_transaction('FE login');
        }

        if (!isset($GLOBALS['TSFE']->fe_user->user['uid']) || $GLOBALS['TSFE']->fe_user->user['uid'] === null) {
            newrelic_add_custom_parameter('Frontend user', 'Anonymous');
        } else {
            $traceFrontendUsersFields = !empty($configuration['traceFrontendUsersFields'])
                ? GeneralUtility::trimExplode(',', $configuration['traceFrontendUsersFields'])
                : ['uid', 'username', 'company', 'email'];
            $traceFields = [];

            foreach ($traceFrontendUsersFields as $traceFrontendUsersField) {
                $traceFields[] = $GLOBALS['TSFE']->fe_user->user[$traceFrontendUsersField];
            }

            newrelic_add_custom_parameter('Frontend user', implode(', ', $traceFields));
        }
    }
}
