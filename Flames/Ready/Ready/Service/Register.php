<?php
declare(strict_types=1);


use Flames\Ready\Ready\Service;

/**
 * @internal
 *
 * Registration entry-point for load, reset and request callbacks.
 *
 * ```php
 * use Flames\Ready\Ready\Service\Register;
 *
 * Register::load(App::class, 'boot');
 * Register::reset(App::class, 'reset');
 * Register::request(fn() => (new App)->handle());
 * ```
 */
final class Register
{
    /**
     * Register a static method to be called **once** when the worker process
     * first becomes active (bootstrap phase).
     *
     * @param class-string $class
     * @param string       $method
     *
     * @return bool Always true.
     */
    public static function load(string $class, string $method): bool {}

    /**
     * Register a static method to be called **after every handled request**
     * to restore per-request state.
     *
     * @param class-string $class
     * @param string       $method
     *
     * @return bool Always true.
     */
    public static function reset(string $class, string $method): bool {}

    /**
     * Start the persistent FastCGI worker supervisor loop (blocking).
     *
     * On **Linux / macOS** this forks `N` worker processes (default: CPUs × 4)
     * and runs a supervisor that reaps dead workers and respawns them.
     * On **Windows** (no `fork()`), this process is simultaneously the
     * supervisor and the sole worker (single-process mode).
     *
     * This method **does not return** under normal operation.
     *
     * @param callable $handler Called once per request. Uncaught exceptions
     *                          are caught automatically and a 500 response
     *                          is sent.
     *
     * @return int Total number of requests handled when the loop eventually
     *             exits.
     */
    public static function request(callable $handler): int {}
}