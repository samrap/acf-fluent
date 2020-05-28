<?php

use Samrap\Acf\Fluent\Builder;
use Tests\Support\Mocks\RunnerMock;
use Tests\TestCase;

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

        $return = $builder->expect('string');

        $this->assertSame($builder, $return);
        $this->assertEquals('string', $builder->expect);
    }

    /** @test */
    public function setDefault()
    {
        $builder = new Builder(new RunnerMock);

        $return = $builder->default('bar');

        $this->assertSame($builder, $return);
        $this->assertEquals('bar', $builder->default);
    }

    /** @test */
    public function setEscape()
    {
        $builder = new Builder(new RunnerMock);

        $return = $builder->escape();

        $this->assertSame($builder, $return);
        $this->assertEquals('esc_html', $builder->escape);
    }

    /** @test */
    public function setEscapeAllowsCustomFunction()
    {
        $builder = new Builder(new RunnerMock);

        $return = $builder->escape('htmlentities');

        $this->assertSame($builder, $return);
        $this->assertEquals('htmlentities', $builder->escape);
    }

    /** @test */
    public function setId()
    {
        $builder = new Builder(new RunnerMock);

        $return = $builder->id(2);

        $this->assertSame($builder, $return);
        $this->assertEquals(2, $builder->id);
    }

    /** @test */
    public function setShortcodes()
    {
        $builder = new Builder(new RunnerMock);

        $return = $builder->shortcodes();

        $this->assertSame($builder, $return);
        $this->assertTrue($builder->shortcodes);
    }

    /** @test */
    public function setRaw()
    {
        $builder = new Builder(new RunnerMock);

        $return = $builder->raw();

        $this->assertSame($builder, $return);
        $this->assertTrue($builder->raw);
    }

    /** @test */
    public function setMatch()
    {
        $builder = new Builder(new RunnerMock);

        $return = $builder->matches('/(regex)/');

        $this->assertSame($builder, $return);
        $this->assertEquals('/(regex)/', $builder->matches);
    }

    /** @test */
    public function applyMacro()
    {
        $builder = new Builder(new RunnerMock, [
            'imageArray' => function (Builder $builder, $a, $b) {
                $builder
                    ->expect('array')
                    ->default(['url' => 'default-image.jpg']);
            },
        ]);
        $return = $builder->imageArray('hi', 12);

        $this->assertSame($builder, $return);
        $this->assertEquals('array', $builder->expect);
        $this->assertEquals(['url' => 'default-image.jpg'], $builder->default);
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     */
    public function throwMethodNotFoundExceptionIfMacroDoesntExist()
    {
        $builder = new Builder(new RunnerMock);
        $builder->nope();
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
