<?php

namespace Samrap\Acf\Fluent;

use Samrap\Acf\Exceptions\BuilderException;

class Builder
{
    /**
     * The Builder's runner.
     *
     * @var \Samrap\Acf\Fluent\Runner
     */
    protected $runner;

    /**
     * The field name or key to build off of.
     *
     * @var string
     */
    public $field;

    /**
     * The post ID to get the field from.
     *
     * @var int
     */
    public $id;

    /**
     * The internal type to expect when retrieving a value.
     *
     * @var string
     */
    public $expect;

    /**
     * The default value to use when retrieving a value that is null or does not
     * pass components added to the builder, such as the 'expect' component.
     *
     * @var mixed
     */
    public $default;

    /**
     * The function to use to escape a retrieved value.
     *
     * @var string
     */
    public $escape;

    /**
     * Whether or not to do shortcodes.
     *
     * @var bool
     */
    public $shortcodes;

    /*
     * Get the field raw (unformatted).
     *
     * @var bool
     */
    public $raw = false;

    /**
     * The regular expression that the field's value must match.
     *
     * @var string
     */
    public $matches;

    /**
     * Create a new Builder instance.
     *
     * @param  \Samrap\Acf\Fluent\Runner  $runner
     */
    public function __construct(Runner $runner)
    {
        $this->runner = $runner;
    }

    /**
     * Get the runner instance.
     *
     * @return \Samrap\Acf\Fluent\Runner
     */
    public function getRunner()
    {
        return $this->runner;
    }

    /**
     * Set the field component.
     *
     * @param  string  $name
     * @return \Samrap\Acf\Fluent\Builder
     */
    public function field($name)
    {
        $this->field = $name;

        return $this;
    }

    /**
     * Set the post component.
     *
     * @param  int  $id
     * @return \Samrap\Acf\Fluent\Builder
     */
    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the expect component.
     *
     * @param  string  $type
     * @return \Samrap\Acf\Fluent\Builder
     */
    public function expect($type)
    {
        $this->expect = $type;

        return $this;
    }

    /**
     * Set the default component.
     *
     * @param  string  $default
     * @return \Samrap\Acf\Fluent\Builder
     */
    public function default($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Set the escape component.
     *
     * @param  callable  $func
     * @return \Samrap\Acf\Fluent\Builder
     */
    public function escape($func = 'esc_html')
    {
        // It is up to the runner to prevent malicious code.
        $this->escape = $func;

        return $this;
    }

    /**
     * Set the shortcodes component.
     *
     * @return \Samrap\Acf\Fluent\Builder
     */
    public function shortcodes()
    {
        $this->shortcodes = true;

        return $this;
    }

    /*
     * Set the raw component.
     *
     * @return \Samrap\Acf\Fluent\Builder
     */
    public function raw()
    {
        $this->raw = true;

        return $this;
    }

    /**
     * Set the matches component.
     *
     * @param  string  $pattern
     * @return \Samrap\Acf\Fluent\Builder
     */
    public function matches($pattern)
    {
        $this->matches = $pattern;

        return $this;
    }

    /**
     * Pass the builder to the runner's get method.
     *
     * @return mixed
     */
    public function get()
    {
        if (is_null($this->field)) {
            throw new BuilderException('Cannot get a null field.');
        }

        return $this->runner->get($this);
    }

    /**
     * Pass the builder and the given value to the runner's update method.
     *
     * @param  mixed  $value
     * @return void
     */
    public function update($value)
    {
        return $this->runner->update($this, $value);
    }
}
