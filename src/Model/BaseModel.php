<?php

namespace App\Model;

use App\Services\Doctrine;
use Doctrine\ORM\EntityManager;

class BaseModel
{
    protected EntityManager $em;

    public function __construct()
    {
        $this->em = Doctrine::getEntityManager();
    }



}