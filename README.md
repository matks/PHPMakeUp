PHPMakeUp
==========

[![Latest Stable Version](https://poser.pugx.org/matks/php-makeup/v/stable.svg)](https://packagist.org/packages/matks/php-makeup)
[![Build Status](https://travis-ci.org/matks/PHPMakeUp.png)](https://travis-ci.org/matks/PHPMakeUp)
[![License](https://poser.pugx.org/matks/php-makeup/license.svg)](https://packagist.org/packages/matks/php-makeup)


PHP Tool that parses php files and applies some esthetic design rules to increase the readability of your code.

## Features

* variables assignment alignment
* use statements ordering

## Installation

Install the dependencies with composer
```bash
composer install
```

## Tests

Install the dev dependencies with composer
```bash
composer install --dev
```

Run the unit tests suite with atoum binary.
```bash
vendor/bin/atoum -bf vendor/autoload.php -d tests/Units/
```

## Usage

Run the following command:
```bash
$ bash php-makeup <folder>
```

## Incoming features:

* phpDoc consistency