# Assigment PHP socket web

## How to running

Run Composer install because I'm use PSR-4

## Installation using Composer

The easiest way to create a new Zend Framework project is to use
[Composer](https://getcomposer.org/).  If you don't have it already installed,
then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

To create your new Zend Framework project:

```bash
$ composer create-project -sdev zendframework/skeleton-application path/to/install
```

Once installed, you can test it out immediately using PHP's built-in web server:

```bash
$ cd path/to/install
$ php -S 0.0.0.0:8080 -t public/ public/index.php
# OR use the composer alias:
$ composer run --timeout 0 serve
```
