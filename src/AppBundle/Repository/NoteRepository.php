<?php
/**
 * Created by PhpStorm.
 * User: brosako
 * Date: 7/26/18
 * Time: 2:21 PM
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Note;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class NoteRepository extends EntityRepository implements NoteRepositoryInterface
{
    public function findById(int $id)
    {
        return parent::find($id);
    }

    public function create(array $noteData, User $user) {
        $note = new Note();
        $note->setTitle($noteData['title']);
        $note->setNote($noteData['note']);
        $note->setUser($user);

        $this->getEntityManager()->persist($note);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->refresh($note);

        return $note;
    }

    public function update(array $noteData, User $user) {
        $note = $this->findOneBy(['id' => $noteData['id'], 'user' => $user->getId()]);

        if (!$note) {
            return false;
        }

        $note->setTitle($noteData['title']);
        $note->setNote($noteData['note']);

        $this->getEntityManager()->flush($note);

        return $note;
    }

    public function delete(int $id, User $user) {
        $note = $this->findOneBy(['id' => $id, 'user' => $user->getId()]);

        if (!$note) {
            return false;
        }

        $this->getEntityManager()->remove($note);
        $this->getEntityManager()->flush();

        return $note;
    }
}