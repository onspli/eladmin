<?php

use Sami\Parser\Filter\TrueFilter;
use Symfony\Component\Finder\Finder;

class Renderer extends Sami\Renderer\Renderer {

}

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in(__DIR__ . '/src')
;

$sami = new Sami\Sami($iterator, [
    'title'     => 'Eladmin Docs',
    'build_dir' => __DIR__ . '/docs',
    'theme'     => 'docs-theme',
    'template_dirs' => ['./docs-theme'],
    'include_parent_data' => true
]);

// document all methods and properties
$sami['filter'] = function () {
    return new TrueFilter();
};

return $sami;
