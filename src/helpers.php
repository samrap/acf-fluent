<?php

use Acf\Acf;

if (! function_exists('fluent_field')) {
    /**
     * Return a new builder instance for a field call.
     *
     * @param  string  $name
     * @param  int  $id
     * @return \Acf\Fluent\Builder
     */
    function fluent_field($name, $id = null)
    {
        return Acf::field($name, $id);
    }
}

if (! function_exists('fluent_sub_field')) {
    /**
     * Return a new builder instance for a subfield call.
     *
     * @param  string  $name
     * @return \Acf\Fluent\Builder
     */
    function fluent_sub_field($name)
    {
        return Acf::subField($name);
    }
}

if (! function_exists('fluent_option')) {
    /**
     * Return a new builder instance for an option field call.
     *
     * @param  string  $name
     * @return \Acf\Fluent\Builder
     */
    function fluent_option($name)
    {
        return Acf::option($name);
    }
}
