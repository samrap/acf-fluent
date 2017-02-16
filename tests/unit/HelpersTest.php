<?php

use Acf\Test\TestCase;
use Acf\Behaviors\FieldBehavior;
use Acf\Behaviors\SubFieldBehavior;

class HelpersTest extends TestCase
{
    public function testFluentFieldFunction()
    {
        $this->assertInstanceOf(
            FieldBehavior::class,
            fluent_field('foo')->getRunner()->getBehavior()
        );
    }

    public function testFluentSubFieldFunction()
    {
        $this->assertInstanceOf(
            SubFieldBehavior::class,
            fluent_sub_field('foo')->getRunner()->getBehavior()
        );
    }

    public function testFluentOptionFunction()
    {
        $builder = fluent_option('foo');

        $this->assertInstanceOf(
            FieldBehavior::class,
            $builder->getRunner()->getBehavior()
        );
        $this->assertEquals('option', $builder->id);
    }
}
