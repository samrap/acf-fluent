<?php

namespace Acf\Behaviors;

class SubFieldBehavior implements BehaviorInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($field, $id = null)
    {
        return get_sub_field($field);
    }

    /**
     * {@inheritdoc}
     */
    public function update($field, $value, $id = null)
    {
        update_sub_field($field, $value, $id);
    }
}
