<?php
declare(strict_types=1);


// @formatter:off
// phpcs:disable

/**
 * Stubs for the cflames_async_service PHP extension.
 *
 * This file is NOT loaded at runtime. Its sole purpose is to provide
 * type information to IDEs and static-analysis tools (PhpStorm, Psalm,
 * PHPStan, etc.) so they understand the classes exported by the C extension.
 *
 * Extension:  cflames_async_service
 * Version:    1.0.0
 * Requires:   PHP 8.5+  (Linux / macOS — uses fork(2))
 *
 * @see \Flames\Async\Async\Service\Task
 */

namespace Flames\Async\Async;

/**
 * @internal
 *
 * Entry point for fork-based parallel execution.
 *
 * All methods are static. The class cannot be instantiated or extended.
 *
 * @package Flames\Async
 */
final class Service
{
    /**
     * Forks a child process immediately and begins executing `$fn` inside it.
     *
     * Returns a {@see \Flames\Async\Async\Service\Task} object **instantly** — the
     * constructor does not wait for the child to finish.  The child and the
     * parent run concurrently from this point on.
     *
     * Variables captured via `use (...)` are available in the closure because
     * the child receives a copy-on-write duplicate of the parent's memory at
     * fork time.  No serialization of input variables is required.
     *
     * Only the **return value** must be serializable (it travels through a
     * pipe back to the parent).  If igbinary is loaded it is used instead of
     * PHP's native `serialize()`.
     *
     * @param callable $fn  Closure (or any callable) to execute asynchronously.
     *
     * @return \Flames\Async\Async\Service\Task  Handle to the running task.
     *
     * @throws \RuntimeException  If the underlying `pipe()` or `fork()` syscall fails.
     *
     * @example
     * ```php
     * use Flames\Async\Async\Service;
     *
     * $type = 'non-admin';
     * $task = Service::async(function() use ($type) {
     *     sleep(2);
     *     return ['users' => [], 'type' => $type];
     * });
     * ```
     */
    public static function fork(callable $fn): \Flames\Async\Async\Service\Task {}

    /**
     * Waits for one or more tasks to finish and returns their results.
     *
     * All child processes were forked at {@see Service::async()} time and are
     * already running concurrently.  `await()` simply blocks on each pipe in
     * argument order and collects the results.
     *
     * **Total wall-time ≈ max(individual durations)**, not the sum.
     *
     * Return value depends on the number of arguments:
     * - **Single task** → returns the closure's return value directly (not wrapped).
     * - **Multiple tasks** → returns an **indexed array** `[result0, result1, …]`
     *   in the same order as the arguments.
     *
     * @param \Flames\Async\Async\Service\Task ...$tasks  One or more Task objects.
     *
     * @return mixed  Single value when one task is given; array when multiple.
     *
     * @throws \RuntimeException  If any task's closure threw an exception
     *                            (the original message is re-thrown).
     * @throws \TypeError         If any argument is not a Task instance.
     *
     * @example
     * ```php
     * use Flames\Async\Async\Service;
     *
     * // Single task – returns value directly
     * $sum = Service::await(Service::async(fn() => array_sum(range(1, 1_000_000))));
     *
     * // Multiple tasks – returns array
     * [$users, $configs] = Service::await($getUsersTask, $getConfigsTask);
     * ```
     */
    public static function wait(\Flames\Async\Async\Service\Task ...$tasks): mixed {}
}
