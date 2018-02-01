<?php

namespace Samrap\Acf;

use Samrap\Acf\Fluent\Runner;
use Samrap\Acf\Fluent\Builder;
use Samrap\Acf\Behaviors\FieldBehavior;
use Samrap\Acf\Behaviors\SubFieldBehavior;

class Acf
{
    /**
     * The class' single instance.
     *
     * @var \Samrap\Acf\Acf
     */
    private static $instance;

    /**
     * The behavior instances.
     *
     * @var \Samrap\Acf\Behaviors\BehaviorInterface[]
     */
    private $behaviors = [];

    /**
     * The available macros defined.
     *
     * @var array
     */
    private $macros = [];

    /**
     * Private constructor to prevent instantiation.
     *
     * @codeCoverageIgnore The class cannot be instantiated.
     */
    private function __construct()
    {
        //
    }

    /**
     * Get the single instance of this object.
     *
     * @return \Samrap\Acf\Acf
     */
    private static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Return a new builder instance for a field call.
     *
     * @param  string  $name
     * @param  int  $id
     * @return \Samrap\Acf\Fluent\Builder
     */
    public static function field($name, $id = null)
    {
        return self::getInstance()
                     ->getBuilder(FieldBehavior::class)
                     ->field($name)
                     ->id($id);
    }

    /**
     * Return a new builder instance for a subfield call.
     *
     * @param  string  $name
     * @return \Samrap\Acf\Fluent\Builder
     */
    public static function subField($name)
    {
        return self::getInstance()
                     ->getBuilder(SubFieldBehavior::class)
                     ->field($name);
    }

    /**
     * Return a new builder instance for an option field call.
     *
     * @param  string  $name
     * @return \Samrap\Acf\Fluent\Builder
     */
    public static function option($name)
    {
        return self::getInstance()
                     ->getBuilder(FieldBehavior::class)
                     ->field($name)
                     ->id('option');
    }

    /**
     * Add a macro to the ACF builder.
     *
     * @param  string  $method
     * @param  callable  $operation
     * @return void
     */
    public static function macro($method, $operation)
    {
        self::getInstance()->macros[$method] = $operation;
    }

    /**
     * Return a builder instance with the given behavior.
     *
     * @param  string  $behavior
     * @return \Samrap\Acf\Fluent\Builder
     */
    private function getBuilder($behavior)
    {
        // Create a new behavior of the given type if one does not yet exist.
        if (! isset($this->behaviors[$behavior])) {
            $this->behaviors[$behavior] = new $behavior();
        }

        return new Builder(new Runner($this->behaviors[$behavior]), $this->macros);
    }
}
