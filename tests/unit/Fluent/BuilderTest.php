<?php

use Tests\TestCase;
use Acf\Fluent\Builder;
use Tests\Support\Mocks\RunnerMock;

class BuilderTest extends TestCase
{
    /** @var \Acf\Fluent\Builder */
    protected $builder;

    public function setUp()
    {
        $this->setFields(['foo' => 'bar']);

        $this->builder = new Builder(new RunnerMock);
    }

    public function testSetField()
    {
        $this->builder->field('foo');

        $this->assertEquals('foo', $this->builder->field);
    }

    public function testSetExpect()
    {
        $this->builder->expect('string');

        $this->assertEquals('string', $this->builder->expect);
    }

    public function testSetDefault()
    {
        $this->builder->default('bar');

        $this->assertEquals('bar', $this->builder->default);
    }

    public function testSetEscape()
    {
        $this->builder->escape();

        $this->assertEquals('esc_html', $this->builder->escape);
    }

    public function testSetEscapeAllowsCustomFunction()
    {
        $this->builder->escape('htmlentities');

        $this->assertEquals('htmlentities', $this->builder->escape);
    }

    public function testSetId()
    {
        $this->builder->id(2);

        $this->assertEquals(2, $this->builder->id);
    }

    public function testFluentBuilder()
    {
        $this->builder
            ->field('foo')
            ->id(2)
            ->expect('string')
            ->default('bar')
            ->escape();

        $this->assertEquals('foo', $this->builder->field);
        $this->assertEquals('string', $this->builder->expect);
        $this->assertEquals('bar', $this->builder->default);
        $this->assertEquals('esc_html', $this->builder->escape);
    }

    public function testBuilderGet()
    {
        $this->assertEquals('bar', $this->builder->field('foo')->get());
    }

    /** @expectedException \Acf\Exceptions\BuilderException */
    public function testBuilderGetThrowsExceptionIfFieldNotSet()
    {
        $this->builder->get();
    }

    public function testBuilderUpdate()
    {
        $this->builder->field('foo')->update('fiz');

        $this->assertEquals('fiz', $this->builder->field('foo')->get());
    }
}
