<?php

// replace with file to your own project bootstrap
$diContainer = require(__DIR__ . '/../src/di.php');

// replace with mechanism to retrieve EntityManager in your app
$entityManager = $diContainer->get('DoctrineEntityManager');

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);