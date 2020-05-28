<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Support\Traits\MocksFields;

class TestCase extends BaseTestCase
{
    use MocksFields;

    /**
     * Set up the test class.
     *
     * @return void
     */
    public function setUp()
    {
        //
    }

    /**
     * Tear down the test class.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->emptyFields();
    }
}
