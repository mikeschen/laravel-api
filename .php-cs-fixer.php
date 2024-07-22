<?php
return (new PhpCsFixer\Config())
    ->setRules([
        'ordered_imports' => true,
        'no_unused_imports' => true,
    ])
    ->setFinder(PhpCsFixer\Finder::create()->in(__DIR__));