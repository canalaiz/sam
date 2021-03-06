# Simple Assets Manager (Laravel 5.* Package)
[![Total Downloads](https://poser.pugx.org/canalaiz/sam/downloads)](https://packagist.org/packages/canalaiz/sam)
[![StyleCI](https://styleci.io/repos/73827252/shield?branch=master)](https://styleci.io/repos/73827252)
[![Build Status](https://travis-ci.org/canalaiz/sam.svg?branch=master)](https://travis-ci.org/canalaiz/sam)
[![Latest Stable Version](https://poser.pugx.org/canalaiz/sam/v/stable)](https://packagist.org/packages/canalaiz/sam)
[![Latest Unstable Version](https://poser.pugx.org/canalaiz/sam/v/unstable)](https://packagist.org/packages/canalaiz/sam)

Sam (short for Simple Assets Manager) is a library built for Laravel 5.*. It provides an easy way to add assets (usually stylesheet or javascript files) to the page after it has been rendered.
Sam, by default, uses simple substr and stripos to inject content within the html page. You can override this behaviour binding a different instance to ```Canalaiz\Sam\Contracts\HtmlInjectEngine```.

## Contents

- [Installation](#installation)
- [Usage](#usage)
    - [Css](#css)
      - [Normal](#css-normal)
      - [Inline](#css-inline)
    - [Javascript](#javascript)
      - [Normal](#javascript-normal)
      - [Inline](#javascript-inline)
    - [Placeholder](#placeholder)
    - [Tag](#tag)
- [License](#license)
- [Contribution guidelines](#contribution-guidelines)

## Installation

1) In order to install Sam, just add the following to your composer.json. Then run `composer update`:

```json
"canalaiz/sam": "1.*"
```

2) Open your `config/app.php` and add the following to the `providers` array:

```php
Canalaiz\Sam\SamServiceProvider::class,
```

3) In the same `config/app.php` and add the following to the `aliases` array: 

```php
'Sam'   => Canalaiz\Sam\Facades\Sam::class,
```

4) Remember to declare Sam Middleware in `app/Http/Kernel.php` in the generic `$middleware` array or within the `$middlewareGroups` array: 

```php
\Canalaiz\Sam\Middleware\Sam::class,
```

## Usage

You can use Sam in every context you like, since the injection happens after views are rendered and before the html is sent to the browser.
The only requirement is to put the use statement:

```php
use Sam;
```

### Css

Css can be appended within document in two different ways: normal and inline. An optional `minify` parameter can be passed as second argument to request css minifying. This parameter defaults to `false` on `Sam::pushCss` and `true` to `Sam::pushInlineCss`. Minified assets are downloaded first and then served locally.

#### Css-Normal
The following command appends a stylesheet tag declaration before the closing of the HEAD tag:

```php
Sam::pushCss('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
```

If you need to minify the asset, use this command:

```php
Sam::pushCss('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', true);
```

#### Css-Inline
The following command appends a stylesheet tag declaration before the closing of the HEAD tag, but content of original source url will be directly injected in the html within a tag:

```php
Sam::pushInlineCss('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
```

### Javascript 

Javascript can be appended within document in two different ways: normal and inline. An optional `minify` parameter can be passed as second argument to request css minifying. This parameter defaults to `false` on `Sam::pushJs` and `true` to `Sam::pushInlineJs`. Minified assets are downloaded first and then served locally.

#### Javascript-Normal
The following command appends a script tag declaration before the closing of the BODY tag:

```php
Sam::pushJs('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
```

If you need to minify the asset, use this command:

```php
Sam::pushJs('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', true);
```

#### Javascript-Inline
The following command appends a script tag declaration before the closing of the BODY tag, but content of original source url will be directly injected in the html within a tag:

```php
Sam::pushInlineJs('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
```

### Placeholder

A placeholder is an html comment in the format: ```<!--PLACEHOLDER-->```. The following command prepends an html block before a specific placeholder:

```php
Sam::pushPlaceholder('PLACEHOLDER', '<div>Hello from Sam!</div>');
```

### Tag 

The following command appends an html block before the closing of a specific tag.

```php
Sam::pushTag('body', '<div>Hello from Sam!</div>');
```

## License

Simple Asset Manager is free software distributed under the terms of the BSD-3-Clause license. Please refer to [license](LICENSE). 

## Contribution guidelines

Support follows PSR-1 and PSR-4 PHP coding standards, and semantic versioning.

Please report any issue you find in the issues page.  
Pull requests are welcome.