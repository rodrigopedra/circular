<?php

namespace App\Models;

use Illuminate\Support\Onceable;

trait PreventsCircularRecursion
{
    // recursion stack
    protected $recursionCache = [];

    protected function withoutRecursion($callback, $default = null)
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);

        $onceable = Onceable::tryFromTrace($trace, $callback);

        if (isset($this->recursionCache[$onceable->hash])) {
            return is_callable($this->recursionCache[$onceable->hash])
                ? $this->recursionCache[$onceable->hash] = call_user_func($this->recursionCache[$onceable->hash])
                : $this->recursionCache[$onceable->hash];
        }

        $this->recursionCache[$onceable->hash] = $default;

        try {
            return call_user_func($callback);
        } finally {
            unset($this->recursionCache[$onceable->hash]);
        }
    }

    public function toArray(): array
    {
        return $this->withoutRecursion(
            fn () => parent::toArray(),
            fn () => $this->attributesToArray(),
        );
    }

    public function push()
    {
        return $this->withoutRecursion(
            fn () => parent::push(),
            true,
        );
    }

    public function getQueueableRelations()
    {
        return $this->withoutRecursion(
            fn () => parent::getQueueableRelations(),
            [],
        );
    }
}
