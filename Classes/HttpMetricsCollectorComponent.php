<?php
declare(strict_types=1);
namespace Flownative\Prometheus\FlowMetrics;

/*
 * This file is part of the Flownative.Prometheus.FlowMetrics package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Prometheus\CollectorRegistry;
use Neos\Flow\Http\Component\ComponentContext;
use Neos\Flow\Http\Component\ComponentInterface;

/**
 * HTTP component which collects HTTP-related metrics for Prometheus
 */
class HttpMetricsCollectorComponent implements ComponentInterface
{
    /**
     * @var CollectorRegistry
     */
    protected $collectorRegistry;

    /**
     * Note: In an Objects.yaml this injection is pre-defined to inject the DefaultCollectorRegistry
     *
     * @param CollectorRegistry $collectorRegistry
     */
    public function injectCollectorRegistry(CollectorRegistry $collectorRegistry): void
    {
        $this->collectorRegistry = $collectorRegistry;
    }

    /**
     * @param ComponentContext $componentContext
     */
    public function handle(ComponentContext $componentContext): void
    {
        $counter = $this->collectorRegistry->getCounter('neos_flow_http_requests_total');
        if ($counter) {
            $counter->inc(1, [
                'status' => $componentContext->getHttpResponse()->getStatusCode()
            ]);
        }
    }
}
