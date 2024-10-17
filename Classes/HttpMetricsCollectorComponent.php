<?php
declare(strict_types=1);
namespace Flownative\Prometheus\FlowMetrics;

/*
 * This file is part of the Flownative.Prometheus.FlowMetrics package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Prometheus\CollectorRegistry;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;

/**
 * PSR-15 Middleware that collects HTTP-related metrics for Prometheus
 */
class HttpMetricsCollectorComponent implements MiddlewareInterface
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

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Handle the request and get the response from the next middleware in the chain
        $response = $handler->handle($request);

        // Collect metrics based on the HTTP response status
        $this->collectorRegistry->getCounter('neos_flow_http_requests_total')
            ->inc(1, [
                'status' => $response->getStatusCode()
            ]);

        // Return the processed response
        return $response;
    }
}
