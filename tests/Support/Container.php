<?php

namespace Tests\Support;

/**
 * This container singleton can be used for testing implementations of the
 * \Acf\Behavior\BehaviorInterface contract.
 */
final class Container
{
    private static $instance;

    private $items = [];

    private function __construct()
    {
        //
    }

    public function _get($key, $default = null)
    {
        return $this->items[$key] ?? $default;
    }

    public function _set($key, $value)
    {
        $this->items[$key] = $value;

        return $this;
    }

    public function _all()
    {
        return $this->items;
    }

    public function _setMany(array $items)
    {
        $this->items = array_merge($this->items, $items);
    }

    public function _empty()
    {
        $this->items = [];
    }

    public static function __callStatic($method, $parameters)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance->{'_'.$method}(...$parameters);
    }
}
