<?php
/**
 * Created by PhpStorm.
 * User: brosako
 * Date: 7/26/18
 * Time: 2:21 PM
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Note;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function findByEmailAndPassword(string $email, string $password) {
        return $this->findOneBy(['email' => $email, 'password' => $password]);
    }
}