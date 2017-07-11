<p align="center">
<a href="https://travis-ci.org/alhoqbani/i18n"><img src="https://travis-ci.org/alhoqbani/i18n.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/alhoqbani/i18n"><img src="https://poser.pugx.org/alhoqbani/i18n/downloads" alt="Total Downloads"></a>
</p>


## Arabic PHP Utilities
### From http://ar-php.org/

This is the great library of Khaled Al-Shamaa with small bug fixes. 

Install it using composer:

```
composer require "arutil/ar-php:0.0.*"
```
or add it in your `composer.json` file:
```
    "require": {
        "arutil/ar-php": "0.0.*"
    }
```


And use it same as the original library at [ar-php.org](www.ar-php.org)

```
<?php 
    
    require_once __DIR__ . '/../vendor/autoload.php';

    $obj = new I18N_Arabic('Numbers');
    echo $obj->int2str(1975); 

```

