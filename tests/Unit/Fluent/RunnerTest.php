<?php

use Tests\TestCase;
use Samrap\Acf\Fluent\Runner;
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
    }

    /** @test */
    public function getsBehavior()
    {
        $this->assertInstanceOf(
            'Samrap\Acf\Behaviors\BehaviorInterface',
            $this->getFreshRunner()->getBehavior()
        );
    }

    /** @test */
    public function setsBehavior()
    {
        $original = $this->getFreshRunner()->getBehavior();

        $this->getFreshRunner()->setBehavior(new BehaviorMock());

        $this->assertNotSame($original, $this->getFreshRunner()->getBehavior());
    }

    /** @test */
    public function runnerGetsField()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'word';

        $this->assertEquals('bar', $this->getFreshRunner()->get($builder));
    }

    /**
     * Ensure that the `format_value` argument can be set to false.
     *
     * @test
     * @see https://www.advancedcustomfields.com/resources/get_field/
     */
    public function runnerGetsFieldNotFormatted()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'word';
        $builder->raw = true;

        $this->assertEquals(
            'bar [not formatted]',
            $this->getFreshRunner()->get($builder)
        );
    }

    /** @test */
    public function runnerUpdatesField()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'bourbon';

        $this->getFreshRunner()->update($builder, 'makers');

        $this->assertEquals('makers', $this->getFreshRunner()->get($builder));
    }

    /** @test */
    public function runnerExpectComponentPasses()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'array';
        $builder->expect = 'array';

        $this->assertInternalType('array', $this->getFreshRunner()->get($builder));
    }

    /** @test */
    public function runnerExpectComponentFails()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'word';
        $builder->expect = 'int';

        $this->assertNull($this->getFreshRunner()->get($builder));
    }

    /** @test */
    public function runnerGetsFieldWithEscapeComponent()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'html';
        $builder->escape = 'esc_html';

        $this->assertEquals(
            '&lt;script src=&quot;something-malicious&quot;&gt;&lt;/script&gt;',
            $this->getFreshRunner()->get($builder)
        );
    }

    /** @test */
    public function escapeComponentWithUrlencode()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'sentence';
        $builder->escape = 'urlencode';

        $this->assertEquals(
            'nothing+is+certain+but+death+and+taxes',
            $this->getFreshRunner()->get($builder)
        );
    }

    /** @test */
    public function escapeComponentIsWhitelisted()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'word';
        $builder->escape = 'strtoupper';

        $this->assertEquals('bar', $this->getFreshRunner()->get($builder));
    }

    /**
     * @test
     * @expectedException \Samrap\Acf\Exceptions\RunnerException
     */
    public function escapeComponentThrowsExceptionForNonString()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'array';
        $builder->escape = 'esc_html';

        $this->getFreshRunner()->get($builder);
    }

    /** @test */
    public function getFieldWithDefaultComponent()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'name';
        $builder->default = 'Bonnie';

        $this->assertEquals('Bonnie', $this->getFreshRunner()->get($builder));
    }

    /** @test */
    public function getFieldWithDefaultComponentWhenValueIsEmptyString()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'empty_string';
        $builder->default = 'Non-empty string';

        $this->assertEquals('Non-empty string', $this->getFreshRunner()->get($builder));
    }

    /** @test */
    public function getFieldWithDefaultComponentWhenValueIsEmptyArray()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'empty_array';
        $builder->default = ['foo' => 'bar'];

        $this->assertEquals(['foo' => 'bar'], $this->getFreshRunner()->get($builder));
    }

    /** @test */
    public function getFieldWithMultipleComponents()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'word';
        $builder->expect = 'int';
        $builder->default = 123;

        $this->assertEquals(123, $this->getFreshRunner()->get($builder));
    }

    /** @test */
    public function doShortcodesOnField()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'word';
        $builder->shortcodes = true;

        $this->assertEquals('shortcode bar', $this->getFreshRunner()->get($builder));
    }

    /**
     * @test
     * @expectedException \Samrap\Acf\Exceptions\RunnerException
     */
    public function doShortcodesOnNonStringFieldThrowsException()
    {
        $builder = $this->createMock('Samrap\Acf\Fluent\Builder');
        $builder->field = 'array';
        $builder->shortcodes = true;

        $this->getFreshRunner()->get($builder);
    }

    /**
     * Get a fresh runner instance for testing.
     *
     * @return \Samrap\Acf\Fluent\Runner
     */
    protected function getFreshRunner()
    {
        return new Runner(new BehaviorMock);
    }
}
