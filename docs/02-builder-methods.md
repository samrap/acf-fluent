# Builder Methods

The real power of ACF Fluent comes when we make full use of the builder. It provides useful methods that can be chained together to build powerful ACF "queries". In this section, we will cover what each of these methods do and how to make use of them.

#### `Samrap\Acf\Fluent\Builder::id(int $id)`

Set the post ID to use when getting or updating a field:

```php
use Samrap\Acf\Acf;

$field = Acf::field('url')
            ->id(2)
            ->get();
```

Alternatively, you may pass the Post ID straight into the static `field` method as the second parameter: `Acf::field('url', 2)->get()`.

#### `Samrap\Acf\Fluent\Builder::default(mixed $value)`

Sometimes, ACF fields or sub fields are left empty by users. We can easily specify a default value by calling the builder's `default` method with any value as its single argument. The default value will be returned if the field is null or empty:

```php
use Samrap\Acf\Acf;

$field = Acf::field('heading')
            ->default('Hello World')
            ->get();
```

When we call the builder's get method, it will now check to make sure the call to `get_field` has returned a null or empty value. If the value is null or empty, we will instead get the string 'Hello World', otherwise we will get the actual value of the `heading` field. In the scope of this package, the term "empty" refers to an empty array or a string whose length is zero.

#### `Samrap\Acf\Fluent\Builder::expect(string $type)`

We can call the `expect` method on a builder instance to specify the type of value that the field is expected to be:

```php
use Samrap\Acf\Acf;

$field = Acf::subField('items')
            ->expect('array')
            ->get();
```

If the result of `items` is an array, then we will get the items just as normal. But if the result is not an array, `null` will be returned as if the value was not even set. Taking our knowledge of this, we can then chain on a `default` value to return instead of null if the type does not match:

```php
use Samrap\Acf\Acf;

$field = Acf::subField('items')
            ->expect('array')
            ->default([])
            ->get();
```

---

**Note:** Aside from the `get` method, which must be called last, the order of method calls on the builder does not matter. It is intellegent enough to know at what point to run each method. 

---

#### `Samrap\Acf\Fluent\Builder::escape(string $func = 'esc_html')`

The `escape` method will run the resulting value through a santization function to ensure the value is properly escaped:

```php
use Samrap\Acf\Acf;

$content = Acf::field('content')
              ->escape()
              ->get();
```

The default santization function is the WordPress [`esc_html`](https://codex.wordpress.org/Function_Reference/esc_html) function. You can specify a different function to run simply by passing the name of the function as the method's single parameter:

```php
use Samrap\Acf\Acf;

$content = Acf::field('content')
              ->escape('esc_url')
              ->get();
```

The current supported functions for the `escape` method are:

- All WordPress escape functions listed [in the codex](https://codex.wordpress.org/Function_Reference/esc_html)
- [`htmlspecialchars()`](http://php.net/manual/en/function.htmlspecialchars.php)
- [`urlencode()`](http://php.net/manual/en/function.urlencode.php)

---

**Tip:** Although ACF Fluent supports `htmlspecialchars` and `urlencode`, it is best to use the escape functions that WordPress provides as they typically contain more secure functionality tailored specifically to WordPress.

---

#### `Samrap\Acf\Fluent\Builder::shortcodes(void)`

ACF already does shortcodes by default with the WYSIWYG field type. However, you may have an alternative field type such as a textarea in which you wish to support shortcodes as well. You could pass the retreived value through the `do_shortcode` function, but with ACF Fluent there is a better way. The `shortcodes` method will instruct ACF Fluent to call the WordPress `do_shortcode` function on the retrieved value automatically:

```php
use Samrap\Acf\Acf;

$content = Acf::field('my_textarea')
              ->shortcodes()
              ->get();
```

If the field value is not a string, a `\Samrap\Acf\Exceptions\RunnerException` exception will be thrown.

#### `Samrap\Acf\Fluent\Builder::raw(void)`

When retrieving a field, ACF lets you specify whether or not to format the value from the database. ACF Fluent follows the plugin's convention by formatting the field by default. You may use the builder's `raw` method to retrieve the value from the database unformatted:

```php
use Samrap\Acf\Acf;

$raw = Acf::field('image')
          ->raw()
          ->get();
```

In this example, the `image` field is never formatted and returned as is from the database.

&larr; [Basic Usage](01-basic-usage.md) |  [Updating Fields](03-updating-fields.md) &rarr;
