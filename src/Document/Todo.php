<?php


namespace App\Document;
use App\Repository\TodoRepository;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;

use Gedmo\SoftDeleteable\Traits\SoftDeleteableDocument;
use Gedmo\Timestampable\Traits\TimestampableDocument;
use JMS\Serializer\Annotation as Serializer;


/**
 * Class Todo
 * @package App\Document
 * @MongoDB\Document(repositoryClass=TodoRepository::class)
 */
class Todo
{
    use TimestampableDocument;
    use SoftDeleteableDocument;

    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @MongoDB\Field(type="bool")
     */
    private $completed = false;

    /**
     * @MongoDB\Field(type="bool")
     */
    private $pinned = false;

    /**
     * @MongoDB\Field(type="string")
     */
    private $color = "#ffffff";

    /**
     * @MongoDB\ReferenceOne(targetDocument=User::class, type="id")
     */
    private $userId;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Todo
     */
    public function setId($id): Todo
    {
        $this->id = $id;
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
     * @return Todo
     */
    public function setName($name): Todo
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * @param mixed $completed
     * @return Todo
     */
    public function setCompleted($completed): Todo
    {
        $this->completed = $completed;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt(): \DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt(\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return mixed
     */
    public function getPinned()
    {
        return $this->pinned;
    }

    /**
     * @param mixed $pinned
     * @return Todo
     */
    public function setPinned($pinned): Todo
    {
        $this->pinned = $pinned;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     * @return Todo
     */
    public function setColor($color): Todo
    {
        $this->color = $color;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     * @return Todo
     */
    public function setUserId($userId): Todo
    {
        $this->userId = $userId;
        return $this;
    }



}