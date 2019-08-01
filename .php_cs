<?php
declare(strict_types=1);

use Narrowspark\CS\Config\Config;

$config = new Config();
$config->getFinder()
    ->files()
    ->in(__DIR__)
    ->exclude('build')
    ->exclude('vendor')
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->notPath('src/TestingHelper/Constraint/ArraySubset.php')
    ->notPath('src/TestingHelper/Phpunit/MockeryTestCase.php')
    ->notPath('tests/Fixture/FooObject.php')
    ->notPath('tests/Fixture/MockObject.php');

$cacheDir = getenv('TRAVIS') ? getenv('HOME') . '/.php-cs-fixer' : __DIR__;

$config->setCacheFile($cacheDir . '/.php_cs.cache');

return $config;
