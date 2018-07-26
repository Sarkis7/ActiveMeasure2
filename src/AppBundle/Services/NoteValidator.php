<?php
/**
 * Created by PhpStorm.
 * User: brosako
 * Date: 7/26/18
 * Time: 3:03 PM
 */

namespace AppBundle\Services;


use AppBundle\Entity\Note;

class NoteValidator
{

    const TITLE_MAX_LENGTH = 50;
    const NOTE_MAX_LENGTH  = 1000;

    private $note;

    private $errors;

    public function __construct($note)
    {
        $this->note = $note;
        $this->errors = [];
    }

    public function validate() {
        if (null !== $id = $this->note['id'] ?? null) {
            if (!filter_var($this->note['id'], FILTER_VALIDATE_INT)) {
                $this->errors['id'] = sprintf('Id is not integer');
            }
        }

        if (null !== $title = ($this->note['title'] ?? null)) {
            if (strlen($title) > self::TITLE_MAX_LENGTH) {
                $this->errors['title'] = sprintf('Title max length is %s', self::TITLE_MAX_LENGTH);
            }
        } else {
            $this->errors['title'] = 'Title is required';
        }

        if (null !== $note = $this->note['note']) {
            if (strlen($note) > self::NOTE_MAX_LENGTH) {
                $this->errors['note'] = sprintf('Note max length is %s', self::NOTE_MAX_LENGTH);
            }
        }
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors() {
        return count($this->errors) > 0;
    }
}