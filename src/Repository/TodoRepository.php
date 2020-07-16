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
}