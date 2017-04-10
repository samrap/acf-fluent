<?php

use Tests\TestCase;
use Samrap\Acf\Fluent\Runner;
use Samrap\Acf\Fluent\Builder;
use Tests\Support\Mocks\RunnerMock;
use Tests\Support\Mocks\BehaviorMock;

class RunnerTest extends TestCase
{
    /** @var \Samrap\Acf\Fluent\Runner */
    protected $runner;

    public function setUp()
    {
        parent::setUp();

        $this->setFields([
            'word' => 'bar',
            'html' => '<script src="something-malicious"></script>',
            'sentence' => 'nothing is certain but death and taxes',
            'array' => ['foo' => 'bar'],
            'empty_string' => '',
            'empty_array' => [],
            'int_string' => '10',
        ]);

        $this->runner = new Runner(new BehaviorMock);
    }

    /** @test */
    public function runnerGetsField()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('word');

        $this->assertEquals('bar', $this->runner->runGet($builder));
    }

    /**
     * Ensure that the `format_value` argument can be set to false.
     *
     * @test
     * @see https://www.advancedcustomfields.com/resources/get_field/
     */
    public function runnerGetsFieldNotFormatted()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('word')->raw();

        $this->assertEquals(
            'bar [not formatted]',
            $this->runner->runGet($builder)
        );
    }

    /** @test */
    public function runnerUpdatesField()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('bourbon');
        $this->runner->runUpdate($builder, 'makers');

        $this->assertEquals('makers', $this->runner->runGet($builder));
    }

    /** @test */
    public function runnerExpectComponentPasses()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('array')->expect('array');

        $this->assertInternalType('array', $this->runner->runGet($builder));
    }

    /** @test */
    public function runnerExpectComponentFails()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('word')->expect('int');

        $this->assertNull($this->runner->runGet($builder));
    }

    /** @test */
    public function runnerGetsFieldWithEscapeComponent()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('html')->escape();

        $this->assertEquals(
            '&lt;script src=&quot;something-malicious&quot;&gt;&lt;/script&gt;',
            $this->runner->runGet($builder)
        );
    }

    /** @test */
    public function escapeComponentWithUrlencode()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('sentence')->escape('urlencode');

        $this->assertEquals(
            'nothing+is+certain+but+death+and+taxes',
            $this->runner->runGet($builder)
        );
    }

    /** @test */
    public function escapeComponentIsWhitelisted()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('word')->escape('strtoupper');

        $this->assertEquals('bar', $this->runner->runGet($builder));
    }

    /**
     * @test
     * @expectedException \Samrap\Acf\Exceptions\RunnerException
     */
    public function escapeComponentThrowsExceptionForNonString()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('array')->escape();

        $this->runner->runGet($builder);
    }

    /** @test */
    public function getFieldWithDefaultComponent()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('name')->default('Bonnie');

        $this->assertEquals('Bonnie', $this->runner->runGet($builder));
    }

    /** @test */
    public function getFieldWithDefaultComponentWhenValueIsEmptyString()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('empty_string')->default('Non-empty string');

        $this->assertEquals('Non-empty string', $this->runner->runGet($builder));
    }

    /** @test */
    public function getFieldWithDefaultComponentWhenValueIsEmptyArray()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('empty_array')->default(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $this->runner->runGet($builder));
    }

    /** @test */
    public function getFieldWithMultipleComponents()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('word')
                ->expect('int')
                ->default(123);

        $this->assertEquals(123, $this->runner->runGet($builder));
    }

    /**
     * Get a fresh builder to work with.
     *
     * @return \Samrap\Acf\Fluent\Builder
     */
    protected function getFreshBuilder()
    {
        return new Builder(new RunnerMock);
    }
}
