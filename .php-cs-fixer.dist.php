<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

return (new Config())
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRiskyAllowed(false)
    ->setRules([
        '@Symfony' => true,
    ])
    ->setFinder(
        (new Finder())
            ->in(['examples', 'src', 'tests']),
    );
