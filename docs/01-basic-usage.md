# Basic Usage

- [Installation](#installation)
- [Core Concepts](#core-concepts)

### Installation

Install via Composer:

```bash
composer require samrap/acf-fluent
```

### Core Concepts

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

[Builder Methods](02-builder-methods.md) &rarr;
