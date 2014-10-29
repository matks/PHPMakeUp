<?php

$autoloadFile = 'vendor/autoload.php';
if (file_exists($autoloadFile)) {
    define('AUTOLOAD_COMPOSER_INSTALL', $autoloadFile);
}

if (!defined('AUTOLOAD_COMPOSER_INSTALL')) {
    echo 'You need to set up the project dependencies using the following commands:' . PHP_EOL .
        'wget http://getcomposer.org/composer.phar' . PHP_EOL .
        'php composer.phar install' . PHP_EOL;
    die(1);
}

require AUTOLOAD_COMPOSER_INSTALL;

if (count($argv) !== 2) {
    echo 'php php-make-up.php <filepath>' . PHP_EOL;
    die(1);
}

Matks\PHPMakeUp\Launcher::main($argv[1]);
