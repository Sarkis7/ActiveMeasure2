<?php
/**
 * Created by PhpStorm.
 * User: brosako
 * Date: 7/26/18
 * Time: 12:10 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateTime;

    /**
     * @ORM\OneToMany(targetEntity="Note", mappedBy="user")
     */
    private $notes;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param mixed $createdTime
     * @return User
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * @param mixed $updateTime
     * @return User
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     * @return User
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
        return $this;
    }
}