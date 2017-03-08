<?php

namespace Tests\Support;

/**
 * This container singleton can be used for testing implementations of the
 * \Samrap\Acf\Behavior\BehaviorInterface contract.
 */
final class Container
{
    /**
     * The container instance.
     *
     * @var \Tests\Support\Container
     */
    private static $instance;

    /**
     * The items in the container.
     *
     * @var  array
     */
    private $items = [];

    /**
     * Private constructor.
     */
    private function __construct()
    {
        //
    }

    /**
     * Get an item from the container.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function _get($key, $default = null)
    {
        return $this->items[$key] ?? $default;
    }

    /**
     * Set an item in the container.
     *
     * @param  string  $key
     * @param  void
     */
    public function _set($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * Get all of the items in the container.
     *
     * @return  array
     */
    public function _all()
    {
        return $this->items;
    }

    /**
     * Set multiple items in the container.
     *
     * @param  array  $items
     * @return void
     */
    public function _setMany(array $items)
    {
        $this->items = array_merge($this->items, $items);
    }

    /**
     * Empty the container.
     *
     * @return void
     */
    public function _empty()
    {
        $this->items = [];
    }

    /**
     * Send static method calls to the container instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance->{'_'.$method}(...$parameters);
    }
}
