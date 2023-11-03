<?php

declare(strict_types=1);

namespace NamelessCoder\NewrelicIntegration\Event;

use TYPO3\CMS\Backend\Controller\Event\ModifyPageLayoutContentEvent;
use TYPO3\CMS\Core\Http\ApplicationType;

class PageLayoutContentEvent
{
    public function setNewrelicNameTransaction(ModifyPageLayoutContentEvent $event)
    {
        if (!extension_loaded('newrelic')) {
            return;
        }

        newrelic_name_transaction('BE/web_layout');
    }
}
