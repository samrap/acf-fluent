<?php

use Tests\TestCase;
use Samrap\Acf\Fluent\Builder;
use Tests\Support\Mocks\RunnerMock;

class BuilderTest extends TestCase
{
    public function setUp()
    {
        $this->setFields(['foo' => 'bar']);
    }

    /** @test */
    public function setField()
    {
        $builder = new Builder(new RunnerMock);

        $builder->field('foo');

        $this->assertEquals('foo', $builder->field);
    }

    /** @test */
    public function setExpect()
    {
        $builder = new Builder(new RunnerMock);

        $builder->expect('string');

        $this->assertEquals('string', $builder->expect);
    }

    /** @test */
    public function setDefault()
    {
        $builder = new Builder(new RunnerMock);

        $builder->default('bar');

        $this->assertEquals('bar', $builder->default);
    }

    /** @test */
    public function setEscape()
    {
        $builder = new Builder(new RunnerMock);

        $builder->escape();

        $this->assertEquals('esc_html', $builder->escape);
    }

    /** @test */
    public function setEscapeAllowsCustomFunction()
    {
        $builder = new Builder(new RunnerMock);

        $builder->escape('htmlentities');

        $this->assertEquals('htmlentities', $builder->escape);
    }

    /** @test */
    public function setId()
    {
        $builder = new Builder(new RunnerMock);

        $builder->id(2);

        $this->assertEquals(2, $builder->id);
    }

    /** @test */
    public function setShortcodes()
    {
        $builder = new Builder(new RunnerMock);

        $builder->shortcodes();

        $this->assertTrue($builder->shortcodes);
    }

    /** @test */
    public function setRaw()
    {
        $builder = new Builder(new RunnerMock);

        $builder->raw();

        $this->assertTrue($builder->raw);
    }

    /** @test */
    public function fluentBuilder()
    {
        $builder = new Builder(new RunnerMock);

        $builder
            ->field('foo')
            ->id(2)
            ->expect('string')
            ->default('bar')
            ->escape();

        $this->assertEquals('foo', $builder->field);
        $this->assertEquals('string', $builder->expect);
        $this->assertEquals('bar', $builder->default);
        $this->assertEquals('esc_html', $builder->escape);
    }

    /** @test */
    public function builderGet()
    {
        $builder = new Builder(new RunnerMock);

        $this->assertEquals('bar', $builder->field('foo')->get());
    }

    /**
     * @test
     * @expectedException \Samrap\Acf\Exceptions\BuilderException
     */
    public function builderGetThrowsExceptionIfFieldNotSet()
    {
        $builder = new Builder(new RunnerMock);

        $builder->get();
    }

    /** @test */
    public function builderUpdate()
    {
        $builder = new Builder(new RunnerMock);

        $builder->field('foo')->update('fiz');

        $this->assertEquals('fiz', $builder->field('foo')->get());
    }
}
