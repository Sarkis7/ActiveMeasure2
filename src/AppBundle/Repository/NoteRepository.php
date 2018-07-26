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

class NoteRepository extends EntityRepository implements NoteRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode = null, $lockVersion = null);
    }

    public function create($noteData) {
        $note = new Note();
        $note->setTitle($noteData['title']);
        $note->setNote($noteData['note']);

        $this->getEntityManager()->persist($note);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->refresh($note);

        return $note;
    }
}