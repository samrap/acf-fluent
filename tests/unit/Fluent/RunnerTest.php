<?php

use Acf\Fluent\Runner;
use Acf\Test\TestCase;
use Acf\Fluent\Builder;
use Acf\Test\Mock\RunnerMock;
use Acf\Test\Mock\BehaviorMock;

class RunnerTest extends TestCase
{
    /** @var \Acf\Fluent\Runner */
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
        ]);

        $this->runner = new Runner(new BehaviorMock);
    }

    public function testRunnerGetsField()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('word');

        $this->assertEquals('bar', $this->runner->runGet($builder));
    }

    public function testRunnerUpdatesField()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('bourbon');
        $this->runner->runUpdate($builder, 'makers');

        $this->assertEquals('makers', $this->runner->runGet($builder));
    }

    public function testRunnerGetsFieldWithExpectComponent()
    {
        $trueBuilder = $this->getFreshBuilder();
        $trueBuilder->field('word')->expect('string');

        $falseBuilder = $this->getFreshBuilder();
        $falseBuilder->field('word')->expect('int');

        $this->assertInternalType(
            'string',
            $this->runner->runGet($trueBuilder)
        );
        $this->assertNull($this->runner->runGet($falseBuilder));
    }

    public function testRunnerGetsFieldWithEscapeComponent()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('html')->escape();

        $this->assertEquals(
            '&lt;script src=&quot;something-malicious&quot;&gt;&lt;/script&gt;',
            $this->runner->runGet($builder)
        );
    }

    public function testEscapeComponentWithUrlencode()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('sentence')->escape('urlencode');

        $this->assertEquals(
            'nothing+is+certain+but+death+and+taxes',
            $this->runner->runGet($builder)
        );
    }

    public function testEscapeComponentIsWhitelisted()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('word')->escape('strtoupper');

        $this->assertEquals('bar', $this->runner->runGet($builder));
    }

    /** @expectedException \Acf\Exceptions\RunnerException */
    public function testEscapeComponentThrowsExceptionForNonString()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('array')->escape();

        $this->runner->runGet($builder);
    }

    public function testGetFieldWithDefaultComponent()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('name')->default('Bonnie');

        $this->assertEquals('Bonnie', $this->runner->runGet($builder));
    }

    public function testGetFieldWithDefaultComponentWhenValueIsEmptyString()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('empty_string')->default('Non-empty string');

        $this->assertEquals('Non-empty string', $this->runner->runGet($builder));
    }

    public function testGetFieldWithDefaultComponentWhenValueIsEmptyArray()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('empty_array')->default(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $this->runner->runGet($builder));
    }

    public function testGetFieldWithMultipleComponents()
    {
        $builder = $this->getFreshBuilder();
        $builder->field('word')
                ->expect('int')
                ->default(123);

        $this->assertEquals(123, $this->runner->runGet($builder));
    }

    protected function getFreshBuilder()
    {
        return new Builder(new RunnerMock);
    }
}
