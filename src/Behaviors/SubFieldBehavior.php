<?php

namespace Samrap\Acf\Behaviors;

class SubFieldBehavior implements BehaviorInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($field, $id = null, $format_value = true)
    {
        $value = get_sub_field($field, $format_value);

        return ($value !== false) ? $value : null;
    }

    /**
     * {@inheritdoc}
     */
    public function update($field, $value, $id = null)
    {
        update_sub_field($field, $value, $id);
    }
}
