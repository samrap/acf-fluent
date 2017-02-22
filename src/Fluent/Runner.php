<?php

namespace Acf\Fluent;

use Acf\Exceptions\RunnerException;
use Acf\Behaviors\BehaviorInterface;

class Runner
{
    /**
     * The behavior to use for ACF function calls.
     *
     * @var \Acf\Behaviors\BehaviorInterface
     */
    protected $behavior;

    /**
     * The \Acf\Fluent\Builder components to run.
     *
     * The components will be executed in the order defined in this array. Only
     * the components defined on the \Acf\Fluent\Builder will be run.
     *
     * @var array
     */
    protected $components = [
        'expect',
        'default',
        'escape',
    ];

    /**
     * Create a new Runner instance.
     *
     * @param  \Acf\Behaviors\BehaviorInterface  $behavior
     */
    public function __construct(BehaviorInterface $behavior)
    {
        $this->behavior = $behavior;
    }

    /**
     * Get the behavior instance.
     *
     * @return \Acf\Behaviors\BehaviorInterface
     */
    public function getBehavior()
    {
        return $this->behavior;
    }

    /**
     * Run the ACF 'get' behavior from the given builder.
     *
     * @param  \Acf\Fluent\Builder  $builder
     * @return mixed
     */
    public function runGet(Builder $builder)
    {
        // First, we will retrieve the field's value using our composed behavior.
        $value = $this->behavior->get($builder->field, $builder->id);

        // Next, we will iterate over the defined components and pass our value
        // through each component's method if it was defined on the builder.
        foreach ($this->components as $component) {
            if (! is_null($builder->$component)) {
                $method = 'run'.ucfirst($component);

                $value = $this->$method($builder->$component, $value);
            }
        }

        return $value;
    }

    /**
     * Run the ACF 'update' behavior from the given builder.
     *
     * @param  \Acf\Fluent\Builder  $builder
     * @param  mixed  $value
     * @return void
     */
    public function runUpdate(Builder $builder, $value)
    {
        $this->behavior->update($builder->field, $value, $builder->id);
    }

    /**
     * Ensure that the value is of the expected type.
     *
     * @param  string  $expected
     * @param  mixed  $value
     * @return mixed
     */
    protected function runExpect($expected, $value)
    {
        return (gettype($value) === $expected) ? $value : null;
    }

    /**
     * Return the default value if the given value is null.
     *
     * @param  mixed  $default
     * @param  mixed  $value
     * @return mixed
     */
    protected function runDefault($default, $value)
    {
        return $value ?? $default;
    }

    /**
     * Escape the value with the given function.
     *
     * @param  string  $func
     * @param  string  $value
     * @return string
     */
    protected function runEscape($func, $value)
    {
        if (! is_string($value)) {
            throw new RunnerException('Cannot escape value of type '.gettype($value));
        }

        $whitelist = [
            'esc_attr',
            'esc_html',
            'esc_js',
            'esc_textarea',
            'esc_url',
            'htmlspecialchars',
            'urlencode',
        ];

        return (in_array($func, $whitelist))
            ? call_user_func($func, $value)
            : $value;
    }
}
