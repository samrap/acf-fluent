<?php

namespace Samrap\Acf\Behaviors;

class FieldBehavior implements BehaviorInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($field, $id = null, $format_value = true)
    {
        return get_field($field, $id, $format_value);
    }

    /**
     * {@inheritdoc}
     */
    public function update($field, $value, $id = null)
    {
        update_field($field, $value, $id);
    }
}
