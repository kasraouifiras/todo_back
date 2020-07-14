<?php


namespace App\Document;
use App\Repository\SoftDeleteRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * Class Todo
 * @package App\Document
 * @MongoDB\Document(repositoryClass=SoftDeleteRepository::class)
 */
class Todo
{
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
     */
    public function setName($name): void
    {
        $this->name = $name;
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
     */
    public function setCompleted($completed): void
    {
        $this->completed = $completed;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @param mixed $deleted_at
     */
    public function setDeletedAt($deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

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
    private $completed;

    /**
     * @MongoDB\Field(type="object_id")
     */
    private $user_id;
    /**
     * @MongoDB\Field(type="date")
     */
    private $created_at;

    /**
     * @MongoDB\Field(type="date")
     */
    private $deleted_at;



}