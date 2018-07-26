<?php
/**
 * Created by PhpStorm.
 * User: brosako
 * Date: 7/26/18
 * Time: 2:23 PM
 */

namespace AppBundle\Repository;


interface NoteRepositoryInterface
{
    public function find($id);
    public function create($noteData);
}