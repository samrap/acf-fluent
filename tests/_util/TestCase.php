<?php

namespace Acf\Test;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setUp()
    {
        //
    }

    /**
     * Populate the global test container with the given items.
     *
     * @param  array  $items
     * @return void
     */
    protected function setFields(array $items)
    {
        Container::setMany($items);
    }

    public function tearDown()
    {
        Container::empty();
    }
}
