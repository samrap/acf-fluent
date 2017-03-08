<?php

namespace Samrap\Acf;

use Samrap\Acf\Fluent\Runner;
use Samrap\Acf\Fluent\Builder;
use Samrap\Acf\Behaviors\FieldBehavior;
use Samrap\Acf\Behaviors\SubFieldBehavior;

class Acf
{
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
     * Return a new builder instance for a field call.
     *
     * @param  string  $name
     * @param  int  $id
     * @return \Samrap\Acf\Fluent\Builder
     */
    public static function field($name, $id = null)
    {
        return static::getBuilder(FieldBehavior::class)
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
        return static::getBuilder(SubFieldBehavior::class)->field($name);
    }

    /**
     * Return a new builder instance for an option field call.
     *
     * @param  string  $name
     * @return \Samrap\Acf\Fluent\Builder
     */
    public static function option($name)
    {
        return static::getBuilder(FieldBehavior::class)
                     ->field($name)
                     ->id('option');
    }

    /**
     * Return a builder instance with the given behavior.
     *
     * @param  string  $behavior
     * @return \Samrap\Acf\Fluent\Builder
     */
    private static function getBuilder($behavior)
    {
        return new Builder(new Runner(new $behavior));
    }
}
