<?php
declare(strict_types=1);

namespace NamelessCoder\NewrelicIntegration\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class NewRelicInstrumentation implements MiddlewareInterface
{
    /**
     * Add custom parameters to newrelic about cache and user_int
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if (
            $GLOBALS['TSFE'] instanceof TypoScriptFrontendController
            && extension_loaded('newrelic')
        ) {
            $userIntInfo = $this->getUserIntInfo();
            newrelic_add_custom_parameter('user_int_count', count($userIntInfo));
            $cacheDisabled = (bool)$GLOBALS['TSFE']->no_cache;
            newrelic_add_custom_parameter('cache_disabled', $cacheDisabled);

        }
        return $response;
    }

    protected function getUserIntInfo(): array
    {
        $userIntInfo = [];
        $intScripts = $GLOBALS['TSFE']->config['INTincScript'] ?? [];

        foreach ($intScripts as $intScriptName => $intScriptConf) {
            $info = isset($intScriptConf['type']) ?  ['TYPE' => $intScriptConf['type']] : [];
            foreach ($intScriptConf['conf'] as $key => $conf) {
                if (is_array($conf)) {
                    $conf = ArrayUtility::flatten($conf);
                }
                $info[$key] = $conf;
            }
            $userIntInfo[$intScriptName] = $info;
        }

        return $userIntInfo;
    }
}
