# Updating Fields

Though typically less common, you may find yourself updating fields or sub fields from time to time. The fluent builder provides you with the `update` method to do just that:

```php
use Samrap\Acf\Acf;

Acf::field('heading')->update('Hello World');
Acf::subField('content')
   ->update('Nothing is certain but death and taxes.');
```

&larr; [Builder Methods](02-builder-methods.md) | &rarr; [Macros](04-macros.md)
