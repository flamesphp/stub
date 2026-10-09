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
 * @see \Flames\Async\Async\Service
 */

namespace Flames\Async\Async\Service;

/**
 * @internal
 *
 * Represents a running asynchronous task.
 *
 * Instances are created exclusively by {@see \Flames\Async\Async\Service::async()}.
 * The class cannot be instantiated directly, cloned, or serialized.
 *
 * Internally the object holds:
 *   - The PID of the forked child process.
 *   - The read end of the Unix pipe used to receive the child's return value.
 *
 * When the object is garbage-collected without having been awaited, the
 * child process is killed with SIGKILL and reaped via `waitpid()` to
 * prevent zombie processes.
 *
 * @package Flames\Async\Async\Service
 */
final class Task
{
    /**
     * Task objects are created internally by {@see \Flames\Async\Async\Service::async()}.
     *
     * @internal
     */
    private function __construct() {}

    /**
     * Non-blocking check: returns `true` if the child has already finished.
     *
     * Uses `select(timeout=0)` under the hood so it never blocks.
     * When this method returns `true` the result is immediately available
     * through {@see result()} or {@see \Flames\Async\Async\Service::await()} without
     * any additional waiting.
     *
     * @return bool  `true` if the task is complete, `false` if still running.
     *
     * @example
     * ```php
     * $task = \Flames\Async\Async\Service::async(function() {
     *     sleep(3);
     *     return 'done';
     * });
     *
     * while (!$task->isDone()) {
     *     echo "Still running...\n";
     *     usleep(500_000);
     * }
     *
     * echo \Flames\Async\Async\Service::await($task); // 'done'
     * ```
     */
    public function isDone(): bool {}

    /**
     * Blocks until the child process finishes and returns its return value.
     *
     * Equivalent to `\Flames\Async\Async\Service::await($this)`.
     *
     * Calling this method (or `await()`) more than once on the same task is
     * safe — the result is cached after the first collection.
     *
     * @return mixed  The value returned by the closure passed to `Service::async()`.
     *
     * @throws \RuntimeException  If the closure threw an exception; the original
     *                            message is preserved in the re-thrown exception.
     *
     * @example
     * ```php
     * $task = \Flames\Async\Async\Service::async(fn() => 42);
     * echo $task->result(); // 42
     * ```
     */
    public function result(): mixed {}
}
