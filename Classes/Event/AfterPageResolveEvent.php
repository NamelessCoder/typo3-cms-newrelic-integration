<?php

declare(strict_types=1);

namespace NamelessCoder\NewrelicIntegration\Event;

use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Frontend\Event\AfterPageAndLanguageIsResolvedEvent;

class AfterPageResolveEvent
{
    /** @var ExtensionConfiguration */
    protected $configuration;

    public function __construct(ExtensionConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function setNewrelicNameTransaction(AfterPageAndLanguageIsResolvedEvent $event)
    {
        if (!extension_loaded('newrelic')) {
            return;
        }

        $applicationType = ApplicationType::fromRequest($event->getRequest())->abbreviate();

        if ($this->isTracePageUidEnabled()) {
            newrelic_name_transaction($applicationType . '/page-' . $event->getController()->id . '-default');

            if ($this->isTracePageTypeEnabled()) {
                $type = $event->getRequest()->getParsedBody()['type']
                    ?? $event->getRequest()->getQueryParams()['type']
                    ?? null;

                if ($type !== null) {
                    newrelic_name_transaction($applicationType . '/page-' . $event->getController()->id . '-type' . $type);
                }
            }
        }
    }

    protected function isTracePageUidEnabled(): bool
    {
        try {
            return (bool)$this->configuration->get('newrelic_integration', 'tracePageUid');
        } catch (ExtensionConfigurationExtensionNotConfiguredException $e) {
            return true;
        } catch (ExtensionConfigurationPathDoesNotExistException $e) {
            return true;
        }
    }

    protected function isTracePageTypeEnabled(): bool
    {
        try {
            return (bool)$this->configuration->get('newrelic_integration', 'tracePageType');
        } catch (ExtensionConfigurationExtensionNotConfiguredException $e) {
            return true;
        } catch (ExtensionConfigurationPathDoesNotExistException $e) {
            return true;
        }
    }
}
