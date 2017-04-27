<?php

use Tests\Support\Container;

function get_field($field, $id = null, $format_value = true)
{
    $value = Container::get($field);

    return (! $format_value && is_string($value))
        ? $value.' [not formatted]'
        : $value;
}

function get_sub_field($field, $format_value = true)
{
    $value = Container::get($field);

    return (! $format_value && is_string($value))
        ? $value.' [not formatted]'
        : $value;
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

function do_shortcode($shortcode)
{
    return 'shortcode '.$shortcode;
}
