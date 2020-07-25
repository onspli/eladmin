<?php

use Sami\Parser\Filter\TrueFilter;

$sami = new Sami\Sami(__DIR__ . '/src', [
    'title'                => 'Eladmin Docs',
    'build_dir'            => __DIR__ . '/docs'
]);

// document all methods and properties
$sami['filter'] = function () {
    return new TrueFilter();
};

return $sami;
