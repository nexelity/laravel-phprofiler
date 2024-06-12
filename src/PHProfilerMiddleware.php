<?php

namespace PHProfiler;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Class PHProfilerMiddleware
 *
 * Middleware for profiling requests and sending profiling data asynchronously.
 *
 * @method phprofiler_enable() void
 * @method phprofiler_disable() array
 */
class PHProfilerMiddleware
{
    protected Client $client;

    /**
     * PHProfilerMiddleware constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {

        // Check if the middleware is enabled
        if (!config('phprofiler.enabled')) {
            return $next($request);
        }

        // Check if the extension is loaded
        if (!function_exists('phprofiler_enable') || !function_exists('phprofiler_disable')) {
            throw new \RuntimeException('PHProfiler extension is not loaded');
        }

        // Check if the DSN is set
        if (!config('phprofiler.dsn')) {
            throw new \RuntimeException('PHProfiler DSN is not set');
        }

        // Start profiling
        phprofiler_enable();

        // Handle the request
        $response = $next($request);

        // Prepare the data
        $data = array_merge(phprofiler_disable(), [
            'action' => sprintf('%s %s', $request->method(), $request->path()),
            'server_name' => $_SERVER['SERVER_NAME'],
            'user' => Auth::id(),
            'ip' => $request->ip(),
            'created_at' => Carbon::now()->toIso8601String(),
        ]);

        // Send data
        $this->sendData($data);

        return $response;
    }

    protected function sendData(array $data): void
    {
        $endpointUrl = config('phprofiler.dsn');
        $this->client->postAsync($endpointUrl, [
            'json' => $data,
            'timeout' => 0.1, // Set a very short timeout to ensure it runs async
        ]);
    }
}