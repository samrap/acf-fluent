<?php

use Acf\Test\Container;

function get_field($field, $id = null)
{
    return Container::get($field);
}

function get_sub_field($field)
{
    return Container::get($field);
}

function update_field($field, $value, $id = null)
{
    Container::set($field, $value);
}

function update_sub_field($field, $value, $id = null)
{
    Container::set($field, $value);
}
