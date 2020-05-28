<?php

namespace Tests\Unit;

use Samrap\Acf\Behaviors\FieldBehavior;
use Samrap\Acf\Behaviors\SubFieldBehavior;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    public function fluentFieldFunction()
    {
        $this->assertInstanceOf(
            FieldBehavior::class,
            fluent_field('foo')->getRunner()->getBehavior()
        );
    }

    /** @test */
    public function fluentSubFieldFunction()
    {
        $this->assertInstanceOf(
            SubFieldBehavior::class,
            fluent_sub_field('foo')->getRunner()->getBehavior()
        );
    }

    /** @test */
    public function fluentOptionFunction()
    {
        $builder = fluent_option('foo');

        $this->assertInstanceOf(
            FieldBehavior::class,
            $builder->getRunner()->getBehavior()
        );
        $this->assertEquals('option', $builder->id);
    }
}
