<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param $email
     * @return null|User
     */
    public function findByEmail($email)
    {
        return $this->findOneBy(['email' => $email]);
    }
}
