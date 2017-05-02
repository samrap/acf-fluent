<p align="center">
<img src="http://i.imgur.com/nrXtc1e.png" width="350px" />
</p>

<p align="center">
<a href="#"><img src="https://img.shields.io/travis/samrap/acf-fluent/master.svg?style=flat-square" alt="Build Status" /></a>
<a href="https://github.com/samrap/acf-fluent/issues"><img src="https://img.shields.io/github/issues/samrap/acf-fluent.svg?style=flat-square" alt="Open Issues" /></a>
<a href="https://packagist.org/packages/samrap/acf-fluent"><img src="https://img.shields.io/packagist/v/samrap/acf-fluent.svg?style=flat-square" alt="Packagist Version" /></a>
<a href="#"><img src="https://img.shields.io/github/license/samrap/acf-fluent.svg?style=flat-square" alt="MIT License" /></a>
</p>

### What is ACF Fluent?

ACF Fluent is a [fluent interface](https://en.wikipedia.org/wiki/Fluent_interface) for the Advanced Custom Fields WordPress plugin. It enables theme developers to create custom field "queries" using an expressive, fluent interface that makes templating with ACF a breeze.

### Why?

If you make heavy use of Advanced Custom Fields in your WordPress templates (you should), then you probably find yourself writing a lot of repetitive code just to print out your fields. For example, you might have a `heading` field for your page's hero section:

```php
<?php

$heading = get_field('heading');

if (is_null('heading')) {
    $heading = get_the_title();
} else {
    $heading = esc_html($heading);
}

?>

<h1><?= $heading ?></h1>
```

As you know, this type of template coding will clutter up your template files quickly, turning your well-structured HTML into a mess of PHP tags and blocks. The worst part is, you'll find yourself not only in a clutter of PHP logic, but repeating the same logic over and over!

ACF Fluent aims to minimize the mess with a fluent builder that lets you easily get and update fields and sub fields and add constraints along the way. Let's take a look at the same functionality above, using ACF Fluent:

```php
<?php

use Samrap\Acf\Acf;

$heading = Acf::field('heading')
                ->default(get_the_title())
                ->escape()
                ->get();

?>

<h1><?= $heading ?></h1>

```

Interested? ACF Fluent packs a lot more features and has **no** dependencies. Keep reading to see all of the awesome features.

### Installation

Install via Composer:

```bash
composer require samrap/acf-fluent
```

### Basic Usage

All calls to ACF Fluent are done through the `Samrap\Acf\Acf` class. This class contains a few static factory methods that always return a `Samrap\Acf\Fluent\Builder` instance. The builder provides the fluent interface for getting and updating fields and sub fields, setting default values, adding constraints, and much more. 

We can retrieve a builder instance for an ACF _field_ by calling the `Samrap\Acf\Acf::field` method, passing in the name of the field as its argument. Let's take a look:

```php
use Samrap\Acf\Acf;

$field = Acf::field('heading');
```

In the above example, we get a new `Samrap\Acf\Fluent\Builder` instance for the `heading` ACF field. We can call the `get` method on the builder to retrieve the field:

```php
use Samrap\Acf\Acf;

$heading = Acf::field('heading')->get();
```

The same can be done for sub fields just as easily via the `subField` method:

```php
use Samrap\Acf\Acf;

$content = Acf::subField('content')->get();
```

And even global option fields:

```php
use Samrap\Acf\Acf;

$toggle = Acf::option('toggle')->get();
```

Alternatively, you can use the `fluent_*` helper functions to return a builder instance. The following functions will return a new builder for fields, sub fields, and options respectively:

```php
fluent_field('name');
fluent_sub_field('name');
fluent_option('name');
```

The field can then be retrieved by calling the `get` method as usual:

```php
$heading = fluent_field('heading')->get();
```

---

**Note:** The fluent helper functions are not included by default. In order to use them, the `vendor/samrap/acf-fluent/src/helpers.php` file will need to be included in your theme.

---

The real power of ACF Fluent comes when we make full use of the builder. It provides useful methods that can be chained together to build powerful ACF "queries". Next, we will cover what each of these methods do and how to make use of them.

### Builder Methods

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

### Updating Fields

Though typically less common, you may find yourself updating fields or sub fields from time to time. The fluent builder provides you with the `update` method to do just that:

```php
use Samrap\Acf\Acf;

Acf::field('heading')->update('Hello World');
Acf::subField('content')
   ->update('Nothing is certain but death and taxes.');
```

### Contributing

ACF Fluent is still in its early stages. Issues, PRs, and enhancement ideas are _highly_ encouraged and appreciated.

---

![Tweeter](http://i.stack.imgur.com/IWyBR.png) Built by [@thesamrapaport](https://twitter.com/thesamrapaport)

The ACF logo is owned by [Elliot Condon](http://www.elliotcondon.com/) and the [Advanced Custom Fields Plugin](https://www.advancedcustomfields.com/)
