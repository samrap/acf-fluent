<?php

use Acf\Acf;
use Acf\Test\TestCase;
use Acf\Fluent\Builder;
use Acf\Behaviors\FieldBehavior;
use Acf\Behaviors\SubFieldBehavior;

class AcfTest extends TestCase
{
    protected $acf;

    public function setUp()
    {
        parent::setUp();

        $this->setFields(['foo' => 'bar']);
    }

    public function testItCreatesBuilder()
    {
        $this->assertInstanceOf(Builder::class, Acf::field('foo'));
        $this->assertInstanceOf(Builder::class, Acf::subField('foo'));
        $this->assertInstanceOf(Builder::class, Acf::option('foo'));
    }

    public function testFieldBuilderUsesRunnerWithFieldBehavior()
    {
        $this->assertInstanceOf(
            FieldBehavior::class,
            Acf::field('foo')->getRunner()->getBehavior()
        );
    }

    public function testSubFieldBuilderUsesRunnerWithSubFieldBehavior()
    {
        $this->assertInstanceOf(
            SubFieldBehavior::class,
            Acf::subField('foo')->getRunner()->getBehavior()
        );
    }

    public function testOptionBuilderUserRunnerWithFieldBehavior()
    {
        $this->assertInstanceOf(
            FieldBehavior::class,
            Acf::option('foo')->getRunner()->getBehavior()
        );
    }

    public function testOptionBuilderUsesOptionPost()
    {
        $this->assertEquals('option', Acf::option('foo')->id);
    }

    public function testSetIdOnFieldMethod()
    {
        $this->assertEquals(2, Acf::field('foo', 2)->id);
    }

    public function testFluentCall()
    {
        $value = Acf::field('title')
                    ->expect('string')
                    ->default('Hello World')
                    ->get();

        $this->assertEquals('Hello World', $value);
    }
}
