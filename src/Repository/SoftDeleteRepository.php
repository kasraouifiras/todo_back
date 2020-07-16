<?php


namespace App\Repository\Traits;


use App\Document\Todo;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

Class SoftDeleteRepository extends DocumentRepository
{

    public function findAllNotDeleted(): array
    {
        return $this->createQueryBuilder()
            ->field('deletedAt')->equals(null)
            ->getQuery()
            ->execute()
            ->toArray();
    }

    public function findNotDeleted($id)
    {
        return $this->createQueryBuilder()
            ->limit(1)
            ->field('deletedAt')->equals(null)
            ->field('id')->equals($id)
            ->getQuery()
            ->getSingleResult();
    }

    public function delete($id){
        return $this->createQueryBuilder()
            ->updateOne()
            ->field('deletedAt')->set(new \DateTime())
            ->field('id')->equals($id)
            ->getQuery()
            ->execute();
    }

    public function restore($id){
        return $this->createQueryBuilder()
            ->updateOne()
            ->field('deletedAt')->set(null)
            ->field('id')->equals($id)
            ->getQuery()
            ->execute();
    }
}