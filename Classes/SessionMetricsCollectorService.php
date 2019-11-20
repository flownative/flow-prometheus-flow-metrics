<?php
declare(strict_types=1);
namespace Flownative\Prometheus\FlowMetrics;

/*
 * This file is part of the Flownative.Prometheus.FlowMetrics package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Prometheus\DefaultCollectorRegistry;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Session\SessionManagerInterface;

/**
 * A service which collects session related metrics for Prometheus
 */
class SessionMetricsCollectorService
{
    /**
     * @Flow\Inject
     * @var DefaultCollectorRegistry
     */
    protected $collectorRegistry;

    /**
     * @Flow\Inject
     * @var SessionManagerInterface
     */
    protected $sessionManager;

    /**
     * @return void
     */
    public function collect(): void
    {
        $this->collectorRegistry->getGauge('neos_flow_sessions')
            ->set(count($this->sessionManager->getActiveSessions()),
                [
                    'state' => 'active'
                ]
            );
    }
}
