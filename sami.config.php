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
    'build_dir' => __DIR__ . '/docs/sami',
    'theme'     => 'docs-theme',
    'template_dirs' => ['./docs-theme'],
    'include_parent_data' => false
]);

// document all methods and properties
$sami['filter'] = function () {
    return new TrueFilter();
};

$sami['twig']->addFilter(
  new \Twig\TwigFilter('markdown_to_html', function ($str) {
    $markdown = new Michelf\MarkdownExtra();
    $str = preg_replace('/```(\w+)/i', '```lang-${1}', $str);
    $str = str_replace('(./docs/', '(../', $str);
    return '<div class="markdown">' . $markdown->transform($str) . '</div>';
  })
);

return $sami;
