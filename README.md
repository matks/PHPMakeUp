PHPMakeUp
==========

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
$ php php-make-up.php <filepath>
```

## Todo

Fix:
- process differently variables assignment for '.=', '=' and '=>' characters