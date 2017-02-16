<?php

namespace Acf\Behaviors;

class SubFieldBehavior implements BehaviorInterface
{
    /**
     * {@inheritDoc}
     */
    public function get($field, $id = null)
    {
        return get_sub_field($field);
    }

    /**
     * {@inheritDoc}
     */
    public function update($field, $value, $id = null)
    {
        update_sub_field($field, $value, $id);
    }
}
