<?php

namespace Acf\Fluent;

use Acf\Exceptions\BuilderException;

class Builder
{
    /**
     * The Builder's runner.
     *
     * @var \Acf\Fluent\Runner
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
     * Create a new Builder instance.
     *
     * @param  \Acf\Fluent\Runner  $runner
     */
    public function __construct(Runner $runner)
    {
        $this->runner = $runner;
    }

    /**
     * Get the runner instance.
     *
     * @return \Acf\Fluent\Runner
     */
    public function getRunner()
    {
        return $this->runner;
    }

    /**
     * Set the field component.
     *
     * @param  string  $name
     * @return \Acf\Fluent\Builder
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
     * @return \Acf\Fluent\Builder
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
     * @return \Acf\Fluent\Builder
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
     * @return \Acf\Fluent\Builder
     */
    public function default($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Set the escape component.
     *
     * @param  string  $func
     * @return \Acf\Fluent\Builder
     */
    public function escape($func = 'htmlspecialchars')
    {
        // It is up to the runner to prevent malicious code.
        $this->escape = $func;

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

        return $this->runner->runGet($this);
    }

    /**
     * Pass the builder and the given value to the runner's update method.
     *
     * @param  mixed  $value
     * @return void
     */
    public function update($value)
    {
        return $this->runner->runUpdate($this, $value);
    }
}
