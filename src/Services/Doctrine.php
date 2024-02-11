<?php

namespace App\Services;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class Doctrine
{
    private static ?Doctrine $instance = NULL;
    private EntityManager $entityManager;

    private function __construct()
    {
        $this->connection();
    }

    public static function getEntityManager(): EntityManager
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance->entityManager;
    }

    private function connection(): void
    {
        $paths = [__DIR__ . '/../Entity/'];
        $proxyDir = __DIR__ . "/DoctrineProxies";
        $config = ORMSetup::createAttributeMetadataConfiguration(
            $paths, false, $proxyDir
        );

        $driverManager = DriverManager::getConnection(
            [
                'driver' => 'pdo_mysql',
                'user' => 'rina',
                'password' => 'panamacity',
                'dbname' => 'BooksDepository',
                'host' => 'localhost',
                'charset' => 'utf8',
                'driverOptions' => [
                    1002 => 'SET NAMES utf8'
                ]
            ],
            $config
        );

        $this->entityManager = new EntityManager($driverManager,$config);
    }
}