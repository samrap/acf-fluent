<?php

namespace Acf\Test\Mock;

use Acf\Test\Container;
use Acf\Behaviors\BehaviorInterface;

class BehaviorMock implements BehaviorInterface
{
    protected $mockedFields;

    public function __construct($fields = [])
    {
        $this->mockedFields = $fields;
    }

    public function get($field, $id = null)
    {
        return Container::get($field);
    }

    public function update($field, $value, $id = null)
    {
        Container::set($field, $value);
    }
}
