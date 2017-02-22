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

function esc_html($text)
{
    return htmlspecialchars($text);
}

function esc_url($text)
{
    return urlencode($text);
}

function esc_js($text)
{
    return $text;
}

function esc_attr($text)
{
    return $text;
}

function esc_textarea($text)
{
    return $text;
}
