<?php


namespace App\Service;


use App\Document\Todo;
use App\Manager\TodoManager;
use JMS\Serializer\SerializerInterface;

class TodoService
{
    private $todoManager;
    private $serializer;

    /**
     * TodoService constructor.
     * @param TodoManager $todoManager
     * @param Serializer $serializer
     */
    public function __construct(TodoManager $todoManager, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->todoManager = $todoManager;
    }

    public function getAll($withTrashed=false){
        $todos =  $this->todoManager->getAll($withTrashed);
        if(count($todos)==0){
            return null;
        }
        return $this->serializer->serialize($todos, 'json');
    }

    public function getUserTodos($userId,$withTrashed=false){
        $todos = $this->todoManager->getUserTodos($userId,$withTrashed);
        if(count($todos)==0){
            return null;
        }
        return $this->serializer->serialize($todos, 'json');
    }

    public function get($id,$withTrashed=false){
        $todo = $this->todoManager->get($id,$withTrashed);
        if(is_null($todo)){
            return null;
        }
        return $this->serializer->serialize($todo, 'json');
    }

    public function update($data, $id){
        $newData =$this->serializer->deserialize($data, 'array','json');
        $todo = $this->todoManager->update($newData,$id);
        if(is_null($todo)){
            return null;
        }
        return $this->serializer->serialize($todo, 'json');
    }

    public function post($data,$userId){
        $deserializedData = $this->serializer->deserialize($data, 'array','json');
        $deserializedData['user_id'] = $userId;
        /** @var Todo $todo */
        $todo = $this->todoManager->post($deserializedData);

        return $this->serializer->serialize($todo, 'json');
    }

    public function delete($id){
        $deleted = $this->todoManager->delete($id);
        return $this->serializer->serialize($deleted, 'json');
    }

    public function clearCompleted($userId){
        $deleted = $this->todoManager->clearCompleted($userId);
        return $this->serializer->serialize($deleted, 'json');
    }

}