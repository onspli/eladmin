<?php
// cli-config.php
require_once __DIR__ . '/examples/doctrine/bootstrap.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
