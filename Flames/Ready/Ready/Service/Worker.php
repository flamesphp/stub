<?php
declare(strict_types=1);


use Flames\Ready\Ready\Service;

/**
 * @internal
 *
 * Utilities available inside a running worker request.
 */
final class Worker
{
    /**
     * Returns `true` when the current process is a Flames Ready worker
     * (i.e. it was spawned by the supervisor and is inside the accept loop).
     *
     * Returns `false` in the supervisor process or when `Register::request()`
     * has not been called yet.
     *
     * @return bool
     */
    public static function isWorker(): bool {}

    /**
     * Returns the total number of requests this worker process has handled
     * since it was spawned.
     *
     * @return int
     */
    public static function getRequestCount(): int {}

    /**
     * Switch the current request to **streaming / passthrough mode**.
     *
     * When called from inside the `Register::request()` handler:
     *   - HTTP headers are sent to the client immediately.
     *   - Subsequent `ob_flush()` / `flush()` calls push data in real time.
     *   - No `Content-Length` header is sent (chunked / streaming response).
     *
     * Useful for Server-Sent Events (SSE), long-polling, or large file
     * streaming where the full response size is not known upfront.
     *
     * Must be called **before** any output is committed; any output already
     * buffered is flushed as the initial body chunk.
     *
     * No-op when called outside of a worker request (e.g. in PHP-FPM mode).
     *
     * @return void
     */
    public static function passthrough(): void {}

    /**
     * Returns an array of PIDs of all currently live worker processes.
     *
     * Works from any context (inside a worker, PHP-FPM, CLI, cron job)
     * because the list is published to a named shared-memory segment.
     *
     * @return list<int>
     */
    public static function getPids(): array {}
}