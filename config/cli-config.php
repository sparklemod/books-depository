<?php

include_once __DIR__.'/../vendor/autoload.php';

use App\Services\Doctrine;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;

$config = new PhpFile(__DIR__ . '/../migrations.php');

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager(Doctrine::getEntityManager()));