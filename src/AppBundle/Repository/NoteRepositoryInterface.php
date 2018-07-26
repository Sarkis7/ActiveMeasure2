<?php
/**
 * Created by PhpStorm.
 * User: brosako
 * Date: 7/26/18
 * Time: 2:23 PM
 */

namespace AppBundle\Repository;


use AppBundle\Entity\User;

interface NoteRepositoryInterface
{
    public function findById(int $id);
    public function create(array $noteData, User $user);
    public function update(array $noteData, User $user);
    public function delete(int $id, User $user);
}