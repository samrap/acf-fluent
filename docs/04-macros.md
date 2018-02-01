# Macros

You may have a chain of methods that are called numerous times throughout your template. For example, imagine you have a repeater field that you loop through in your template and thus need to ensure that the result is always an array. Without ACF Fluent, that might look something like this:

```php
<?php

$items = get_field('items');

?>

<?php if (is_array($items)): ?>
    <?php foreach ($items as $item): ?>
        <!-- Some HTML Markup -->
    <?php endforeach; ?>
<?php endif; ?>

```

As you know, we can use ACF Fluent to clean this up a bit:

```php
<?php foreach (Acf::field('items')->expect('array')->default([])->get() as $item): ?>
    <!-- Some HTML Markup -->
<?php endforeach; ?>
```

This is nice, but can get a bit cumbersome to retype every single time we need to loop over a repeater field. ACF Macros allow you to chain together existing methods into one single method that can be called on the builder.

First, define the Macro statically on the `Acf` object (this should be done upon setup, like in `functions.php`):

```php
use Samrap\Acf\Acf;
use Samrap\Acf\Fluent\Builder;

Acf::macro('repeater', function (Builder $builder) {
    $builder
        ->expect('array')
        ->default([]);
});
```

Now, we can call `repeater` as a method of the Fluent Builder anywhere in our code:

```php
<?php foreach (Acf::field('items')->repeater()->get() as $item): ?>
    <!-- Some HTML Markup -->
<?php endforeach; ?>
```

As you can see, this is a nice shortcut to making complex builder calls. With all the [Builder Methods](02-builder-methods.md) available, you can imaging that macros are a good option to further organize your templates.

&larr; [Updating Fields](03-updating-fields.md)
