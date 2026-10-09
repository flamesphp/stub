<?php
declare(strict_types=1);


namespace Flames\Ready\Ready;

final class Service
{
    /**
     * @internal
     *
     * Returns `true` if the load callbacks have already been executed for
     * this worker process.
     *
     * Useful to guard `Register::load` calls so they are not repeated:
     *
     * ```php
     * if (!Service::isReady()) {
     *     Register::load(App::class, 'boot');
     * }
     * ```
     *
     * @return bool
     */
    public static function isReady(): bool {}
}