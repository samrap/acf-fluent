<?php

namespace Acf\Behaviors;

class FieldBehavior implements BehaviorInterface
{
    /**
     * {@inheritDoc}
     */
    public function get($field, $id = null)
    {
        return get_field($field, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function update($field, $value, $id = null)
    {
        update_field($field, $value, $id);
    }
}
