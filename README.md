phileRender
===========

Render the content of a page by passing it's URL.

**This plugin requires that you use Twig for your template engine**

### 1.1 Installation (composer)
```
php composer.phar require phile/render:*
```

### 1.2 Installation (Download)

* Install [Phile](https://github.com/PhileCMS/Phile)
* Clone this repo into `plugins/phile/render`
* add `$config['plugins']['phile\\render'] = array('active' => true);` to your `config.php`

### Usage

There will now be a new twig function called `render`. It takes a URL to a page, and renders the HTML for it!

#### Basic Examples:

The path is the same as the way we load pages via URLs.

Let's say we have a page at `content/special.md`, then we will use:

```html
{{ render('special') }}
```

This will render the HTML of the `special` page.

Let's say we have a page at `content/sub/special-nested.md`, then we will use:

```html
{{ render('sub/special-nested') }}
```

This will render the HTML of the `sub/special-nested` page.

#### Conditional Examples

In the config file you can set conditionals so you don't load a page that may not be setup for loading in this way.

```php
return array(
  'conditional_checks' => array(
    'template' => 'partial',
    'role' => 'custom'
  )
);
```

This conditional means: only load pages that have a template of 'partial' and a role that is 'custom'. We can use *any custom meta* for the conditionals. We can also use multiple key => values for checking as you can see from the example.

### Errors

This plugin will fail silently if no page is found, or the conditional is not met.
