<p align="center">
<img src="http://i.imgur.com/nrXtc1e.png" width="350px" />
</p>

<p align="center">
<a href="#"><img src="https://img.shields.io/travis/samrap/acf-fluent/master.svg?style=flat-square" alt="Build Status" /></a>
<a href="https://scrutinizer-ci.com/g/samrap/acf-fluent/?branch=master"><img src="https://img.shields.io/scrutinizer/g/samrap/acf-fluent.svg?style=flat-square" alt="Code Quality" /></a>
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

Interested? ACF Fluent packs a lot more features and has **no** dependencies. [Check out the docs](docs/01-basic-usage.md) see all of the awesome features.

### Documentation

- [Basic Usage](docs/01-basic-usage.md)
- [Builder Methods](docs/02-builder-methods.md)
- [Updating Fields](docs/03-updating-fields.md)

### Contributing

ACF Fluent is still in its early stages. Issues, PRs, and enhancement ideas are encouraged and appreciated.

---

![Tweeter](http://i.stack.imgur.com/IWyBR.png) Built by [@thesamrapaport](https://twitter.com/thesamrapaport)

The ACF logo is owned by [Elliot Condon](http://www.elliotcondon.com/) and the [Advanced Custom Fields Plugin](https://www.advancedcustomfields.com/)
