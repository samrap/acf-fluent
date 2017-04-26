<?php

namespace Tests\Unit;

use Samrap\Acf\Acf;
use Tests\TestCase;
use Samrap\Acf\Fluent\Builder;
use Samrap\Acf\Behaviors\FieldBehavior;
use Samrap\Acf\Behaviors\SubFieldBehavior;

class AcfTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->setFields(['foo' => 'bar']);
    }

    /** @test */
    public function itCreatesBuilder()
    {
        $this->assertInstanceOf(Builder::class, Acf::field('foo'));
        $this->assertInstanceOf(Builder::class, Acf::subField('foo'));
        $this->assertInstanceOf(Builder::class, Acf::option('foo'));
    }

    /** @test */
    public function fieldBuilderUsesRunnerWithFieldBehavior()
    {
        $this->assertInstanceOf(
            FieldBehavior::class,
            Acf::field('foo')->getRunner()->getBehavior()
        );
    }

    /** @test */
    public function subFieldBuilderUsesRunnerWithSubFieldBehavior()
    {
        $this->assertInstanceOf(
            SubFieldBehavior::class,
            Acf::subField('foo')->getRunner()->getBehavior()
        );
    }

    /** @test */
    public function optionBuilderUsesRunnerWithFieldBehavior()
    {
        $this->assertInstanceOf(
            FieldBehavior::class,
            Acf::option('foo')->getRunner()->getBehavior()
        );
    }

    /** @test */
    public function optionBuilderUsesOptionPost()
    {
        $this->assertEquals('option', Acf::option('foo')->id);
    }

    /** @test */
    public function sameBuilderInRunner()
    {
        $one = Acf::field('foo');
        $two = Acf::field('bar');
        $three = Acf::subField('baz');

        // Make sure that both `field` queries use the same behavior instance...
        $this->assertSame(
            $one->getRunner()->getBehavior(),
            $two->getRunner()->getBehavior()
        );

        // ...But the `subField` query should have its own behavior.
        $this->assertNotSame(
            $one->getRunner()->getBehavior(),
            $three->getRunner()->getBehavior()
        );
    }

    /** @test */
    public function setIdOnFieldMethod()
    {
        $this->assertEquals(2, Acf::field('foo', 2)->id);
    }

    /** @test */
    public function fluentCall()
    {
        $value = Acf::field('title')
                    ->expect('string')
                    ->default('Hello World')
                    ->get();

        $this->assertEquals('Hello World', $value);
    }
}
