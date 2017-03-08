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

    /** @test */
    public function setField()
    {
        $this->builder->field('foo');

        $this->assertEquals('foo', $this->builder->field);
    }

    /** @test */
    public function setExpect()
    {
        $this->builder->expect('string');

        $this->assertEquals('string', $this->builder->expect);
    }

    /** @test */
    public function setDefault()
    {
        $this->builder->default('bar');

        $this->assertEquals('bar', $this->builder->default);
    }

    /** @test */
    public function setEscape()
    {
        $this->builder->escape();

        $this->assertEquals('esc_html', $this->builder->escape);
    }

    /** @test */
    public function setEscapeAllowsCustomFunction()
    {
        $this->builder->escape('htmlentities');

        $this->assertEquals('htmlentities', $this->builder->escape);
    }

    /** @test */
    public function setId()
    {
        $this->builder->id(2);

        $this->assertEquals(2, $this->builder->id);
    }

    /** @test */
    public function fluentBuilder()
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

    /** @test */
    public function builderGet()
    {
        $this->assertEquals('bar', $this->builder->field('foo')->get());
    }

    /**
     * @test
     * @expectedException \Acf\Exceptions\BuilderException
     */
    public function builderGetThrowsExceptionIfFieldNotSet()
    {
        $this->builder->get();
    }

    /** @test */
    public function builderUpdate()
    {
        $this->builder->field('foo')->update('fiz');

        $this->assertEquals('fiz', $this->builder->field('foo')->get());
    }
}
