<?php


namespace App\Repository;


use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class SoftDeleteRepository extends DocumentRepository
{

    public function findByUserNotDeleted($user_id){
        return $this->createQueryBuilder()
            ->field('user_id')->equals($user_id)
            ->field('deleted_at')->equals(null)
            ->getQuery()
            ->execute()
            ->toArray();
    }

    public function findAllNotDeleted(){
       return $this->createQueryBuilder()
           ->field('deleted_at')->equals(null)
           ->getQuery()
           ->execute()
           ->toArray();
    }

    public function findNotDeleted($id){
        return $this->createQueryBuilder()
            ->field('deleted_at')->equals(null)
            ->field('id')->equals($id)
            ->getQuery()
            ->execute()
            ->toArray();
    }

    public function delete($id){
        return $this->createQueryBuilder()
            ->updateOne()
            ->field('deleted_at')->set(new Carbon())
            ->field('id')->equals($id)
            ->getQuery()
            ->execute();
    }

    public function restore($id){
        return $this->createQueryBuilder()
            ->updateOne()
            ->field('deleted_at')->set(null)
            ->field('id')->equals($id)
            ->getQuery()
            ->execute();
    }
}