# hoppinger/config-kernel

A Symfony [HTTP Kernel](https://github.com/symfony/HttpKernel) implementation to use with Hoppinger's cnf/target configuration paradigm.

[![Build Status](https://travis-ci.org/hoppinger/config-kernel.png?branch=master)](https://travis-ci.org/hoppinger/config-kernel)

## Installation

The recommended way to install this is with [Composer](http://getcomposer.org/). 
Just add `hoppinger/config-kernel` to your composer.json by running:

``` bash
$ php composer.phar require hoppinger/config-kernel
```

## Usage

When using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard), make `app/AppKernel.php` and `web/app.php` look something like this:

```php
// app/AppKernel.php

use Hop\Config\Kernel\Kernel;

class AppKernel extends Kernel
{
	/* .... */
}
```

```php
// web/app.php
use Hop\Config\Target\Target;

require_once __DIR__.'/../app/AppKernel.php';
$target = new Target(__DIR__.'/../cnf', 'dev/foo');
$kernel = new AppKernel($target);
```

Target `dev/foo` means the app will be bootstrapped with mode `dev` and subtarget `foo`.

This will, besides loading the `app/config/config_dev.yml` configuration, also load the `cnf/targets/dev/foo/config.yml` configuration. 

## Copyright

hoppinger/config-kernel is licensed under the MIT license.    