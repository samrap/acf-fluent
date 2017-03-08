<?php

namespace Samrap\Acf\Behaviors;

class FieldBehavior implements BehaviorInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($field, $id = null)
    {
        return get_field($field, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function update($field, $value, $id = null)
    {
        update_field($field, $value, $id);
    }
}
