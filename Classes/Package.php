<?php
namespace Flownative\Prometheus\FlowMetrics;

/*
 * This file is part of the Flownative.Prometheus.FlowMetrics package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Neos\Flow\Configuration\ConfigurationManager;
use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Package\Package as BasePackage;

class Package extends BasePackage
{
    /**
     * @param Bootstrap $bootstrap
     */
    public function boot(Bootstrap $bootstrap): void
    {
        $dispatcher = $bootstrap->getSignalSlotDispatcher();
        $dispatcher->connect(ConfigurationManager::class, 'configurationManagerReady', function (ConfigurationManager $configurationManager) {
            $configurationManager->registerConfigurationType('Settings', ConfigurationManager::CONFIGURATION_PROCESSING_TYPE_SETTINGS, true);
        });
    }
}
