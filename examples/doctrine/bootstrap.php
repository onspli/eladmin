<?php

use Doctrine\ORM;

require_once __DIR__ . '/../../vendor/autoload.php';

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = ORM\Tools\Setup::createAnnotationMetadataConfiguration(array(__DIR__ . '/src'), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/test.sqlite',
);

// obtaining the entity manager
$entityManager = ORM\EntityManager::create($conn, $config);
