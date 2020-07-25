<?php

use Sami\Parser\Filter\TrueFilter;

$sami = new Sami\Sami(__DIR__ . '/src', [
    'title'     => 'Eladmin Docs',
    'build_dir' => __DIR__ . '/docs',
    'theme'     => 'docs-theme',
    'template_dirs' => ['./docs-theme']
]);

// document all methods and properties
$sami['filter'] = function () {
    return new TrueFilter();
};

return $sami;
