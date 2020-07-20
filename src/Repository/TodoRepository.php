<?php


namespace App\Repository;


use App\Repository\Traits\SoftDeleteRepository;
use MongoDB\BSON\ObjectId;

class TodoRepository extends SoftDeleteRepository
{
    public function findByUserNotDeleted($userId): array
    {
        return $this->createQueryBuilder()
            ->field('userId')->equals(new ObjectId($userId))
            ->field('deletedAt')->equals(null)
            ->getQuery()
            ->execute()
            ->toArray();
    }

    public function clearCompleted($userId)
    {
        return $this->createQueryBuilder()
            ->updateMany()
            ->field('userId')->equals(new ObjectId($userId))
            ->field('completed')->equals(true)
            ->field('deletedAt')->equals(null)
            ->field('deletedAt')->set(new \DateTime())
            ->getQuery()
            ->execute();
    }
}