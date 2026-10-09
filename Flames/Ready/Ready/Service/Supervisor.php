<?php
declare(strict_types=1);


use Flames\Ready\Ready\Service;

/**
 * @internal
 *
 * Supervisor controls.
 */
final class Supervisor
{
    /**
     * Returns `true` when the current process is the Flames Ready supervisor
     * (the process that called `Register::request()`).
     *
     * @return bool
     */
    public static function isSupervisor(): bool {}

    /**
     * Signal all workers to exit gracefully after finishing their current
     * request and be respawned by the supervisor with fresh state.
     *
     * **Works from any process** — including external CLI scripts, PHP-FPM
     * requests, or cron jobs — by writing to the named shared-memory segment
     * that all processes share. The supervisor detects the change on its next
     * 1-second heartbeat tick and propagates it to the workers.
     *
     * Use after deploying new code to hot-reload workers without downtime.
     *
     * Returns `false` when no supervisor is running (named shm not found).
     *
     * @return void|false  `false` if no supervisor is running, `null` otherwise.
     */
    public static function reloadWorkers(): mixed {}

    /**
     * Returns the PID of the supervisor process, or `null` when no supervisor
     * is running.
     *
     * Works from any context (inside a worker, PHP-FPM, CLI) because the PID
     * is published to a named shared-memory segment.
     *
     * @return int|null
     */
    public static function getPid(): ?int {}
}