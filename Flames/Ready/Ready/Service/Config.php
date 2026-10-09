<?php
declare(strict_types=1);


use Flames\Ready\Ready\Service;

/**
 * @internal
 *
 * Runtime configuration for the running supervisor.
 *
 * Changes take effect within ~1 second (the supervisor polls every second).
 * Values are propagated via shared memory so they can be set from any PHP
 * process on the same host.
 */
final class Config
{
    /**
     * Dynamically adjust the number of concurrent worker processes.
     *
     * - **Scale up**: the supervisor spawns additional workers immediately.
     * - **Scale down**: excess workers receive SIGTERM and exit after their
     *   current request finishes.
     *
     * The value is clamped to `[1, 512]`.
     *
     * Can be called from any context (inside or outside the supervisor tree).
     * If no supervisor is running, a warning is emitted.
     *
     * @param int $count Desired worker count (1 – 512).
     *
     * @return void
     */
    public static function setWorkers(int $count): void {}
}