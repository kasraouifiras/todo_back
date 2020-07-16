<?php


namespace App\Manager;


use App\Document\Todo;
use Doctrine\ODM\MongoDB\DocumentManager;
use JMS\Serializer\Serializer;

class TodoManager
{
    private $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function getTodoRepository()
    {
        return $this->dm->getRepository(Todo::class);
    }

    public function getAll($withTrashed=false)
    {
        if($withTrashed){
            return $this->getTodoRepository()->findAll();
        }else{
            return $this->getTodoRepository()->findAllNotDeleted();
        }
    }

    public function getUserTodos($userId,$withTrashed=false){
        if ($withTrashed){
            return $this->getTodoRepository()->findBy(['userId'=>$userId]);
        }else{
            return $this->getTodoRepository()->findByUserNotDeleted($userId);
        }
    }

    public function get($id,$withTrashed=false)
    {
        if($withTrashed){
            return $this->getTodoRepository()->find($id);
        }else{
            return $this->getTodoRepository()->findNotDeleted($id);
        }
    }

    public function update($newData, $id): ?Todo
    {
        /** @var Todo $todo */
        $todo = $this->get($id);
        if(is_null($todo)){
            return null;
        }
        foreach ($newData as $key=>$value){
            switch ($key){
                case 'name':{
                    $todo->setName($value);
                }
                case 'completed':{
                    $todo->setCompleted($value);
                }
            }
        }
        $this->dm->flush();
        return $todo;
    }

    public function post($data){
        /** @var Todo $todo */
        $todo = new Todo();
        $todo->setName($data['name'])->setUserId($data['user_id']);
        $this->dm->persist($todo);
        $this->dm->flush();

        return $todo;
    }

    public function delete($id){
        $todo = $this->get($id);
        if (is_null($todo)){
            return false;
        }
        $this->getTodoRepository()->delete($id);
        $this->dm->flush();
        return true;
    }

}