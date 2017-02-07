<?php
namespace NamelessCoder\NewrelicIntegration\Hooks;

use TYPO3\CMS\Core\DataHandling\DataHandler;

/**
 * Names transactions based on the DataHandler action being performed
 */
class DataHandlerHookSubscriber
{
    /**
     * Command post processing method
     *
     * Name the transaction based on the action being performed.
     * Include the ID and other aspects in custom Newrelic parameters.
     *
     * @param string $command The TCEmain operation status, fx. 'update'
     * @param string $table The table TCEmain is currently processing
     * @param string $id The records id (if any)
     * @param string $relativeTo Filled if command is relative to another element
     * @param DataHandler $reference Reference to the parent object (TCEmain)
     * @return void
     */
    public function processCmdmap_postProcess(&$command, $table, $id, &$relativeTo, &$reference)
    {
        newrelic_name_transaction('BE/command/' . $command);
        newrelic_add_custom_parameter('command_table', $table);
        newrelic_add_custom_parameter('command_id', $id);
        newrelic_add_custom_parameter('command_relativeTo', $relativeTo);
    }
}
