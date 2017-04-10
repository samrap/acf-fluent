<?php

namespace Tests\Support\Mocks;

use Tests\Support\Container;
use Samrap\Acf\Behaviors\BehaviorInterface;

class BehaviorMock implements BehaviorInterface
{
    protected $mockedFields;

    public function __construct($fields = [])
    {
        $this->mockedFields = $fields;
    }

    public function get($field, $id = null, $format_value = true)
    {
        return get_field($field, $id, $format_value);
    }

    public function update($field, $value, $id = null)
    {
        update_field($field, $value);
    }
}
