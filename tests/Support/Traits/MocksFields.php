<?php

namespace Tests\Support\Traits;

use Tests\Support\Container;

trait MocksFields
{
    /**
     * Populate the global test container with the given items.
     *
     * @param  array  $items
     * @return void
     */
    protected function setFields(array $items)
    {
        Container::setMany($items);
    }

    /**
     * Empty the global test container.
     *
     * @return void
     */
    protected function emptyFields()
    {
        Container::empty();
    }
}
