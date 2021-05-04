<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in('src')
    ->in('tests');

$config = new Config();

return $config
    ->setRules([
        '@PSR12' => true,
    ])
    ->setFinder($finder);
