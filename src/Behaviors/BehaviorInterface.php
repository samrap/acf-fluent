<?php

namespace Samrap\Acf\Behaviors;

interface BehaviorInterface
{
    /**
     * Get a field.
     *
     * @param  string  $field
     * @param  int  $id
     * @return mixed
     */
    public function get($field, $id);

    /**
     * Update a field.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @param  int  $id
     * @return void
     */
    public function update($field, $value, $id);
}
