<?php


namespace App\Controller;

use App\Document\Todo;
use Carbon\Carbon;
use Doctrine\ODM\MongoDB\DocumentManager;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{
    /**
     * @param DocumentManager $dm
     * @return Response
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     * @Route("/api/todos", name="add_todo", methods={"POST"})
     */
    public function store(Request $request,DocumentManager $dm)
    {
        $serialize = SerializerBuilder::create()->build();
        $input = json_decode($request->getContent(),true);
        $todo = new Todo();
        $todo->setName($input['name']);
        $todo->setCompleted(false);
        $todo->setUserId($this->getUser()->getId());
        $todo->setCreatedAt(Carbon::now()->toDate());
        $todo->setDeletedAt(null);
        $dm->persist($todo);
        $dm->flush();
        $data = $serialize->serialize($todo,'json');


        $res = ["data"=>$todo,"message"=>"todos stored","success"=>true];
        $jres = $serialize->serialize($res,'json');
        return new Response($jres);
    }

    /**
     * @param DocumentManager $dm
     * @return Response
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     * @Route("/api/todos", name="show_todos", methods={"GET"})
     */
    public function showAll(DocumentManager $dm)
    {
        $todos = $dm->getRepository(Todo::class)->findByUserNotDeleted($this->getUser()->getId());
        $serialize = SerializerBuilder::create()->build();
        if(!$todos){
            $res = ["message"=>"No todos found","success"=>false];
            $jres = $serialize->serialize($res,'json');
            return new Response($jres,400);
        }

        $res = ["data"=>$todos,"message"=>"todos found","success"=>true];
        $jres = $serialize->serialize($res,'json');
        return new Response($jres);
    }

    /**
     * @param DocumentManager $dm
     * @return Response
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     * @Route("/api/todos/{id}", name="show_todo", methods={"GET"})
     */
    public function show($id,DocumentManager $dm)
    {
        $todo = $dm->getRepository(Todo::class)->findNotDeleted($id);
        $serialize = SerializerBuilder::create()->build();
        if(!$todo){
            $res = ["message"=>"No todo with this id","success"=>false];
            $jres = $serialize->serialize($res,'json');
            return new Response($jres,400);
        }

        $res = ["data"=>$todo,"message"=>"todos found","success"=>true];
        $jres = $serialize->serialize($res,'json');
        return new Response($jres);
    }

    /**
     * @param DocumentManager $dm
     * @return Response
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     * @Route("/api/todos/{id}", name="update_todo", methods={"PUT","PATCH"})
     */
    public function update(Request $request,$id,DocumentManager $dm)
    {
        $input = json_decode($request->getContent(),true);
        $todo = $dm->getRepository(Todo::class)->find($id);
        $serialize = SerializerBuilder::create()->build();
        if(!$todo){
            $res = ["message"=>"No todo with this id","success"=>false];
            $jres = $serialize->serialize($res,'json');
            return new Response($jres,400);
        }

        if(isset($input['name']))
            $todo->setName($input['name']);
        if(isset($input['completed']))
            $todo->setCompleted($input['completed']);

        $dm->flush();

        $res = ["data"=>$todo,"message"=>"todo updated","success"=>true];
        $jres = $serialize->serialize($res,'json');
        return new Response($jres);
    }

    /**
     * @param DocumentManager $dm
     * @return Response
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     * @Route("/api/todos/{id}", name="delete_todo", methods={"DELETE"})
     */
    public function delete($id,DocumentManager $dm)
    {
        /** @var $todo Todo */
        $todo = $dm->getRepository(Todo::class)->find($id);
        $serialize = SerializerBuilder::create()->build();
        if(!$todo){
            $res = ["message"=>"No todo with this id","success"=>false];
            $jres = $serialize->serialize($res,'json');
            return new Response($jres,400);
        }

        $dm->getRepository(Todo::class)->delete($todo->getId());
        $dm->flush();


        $res = ["message"=>"todo deleted","success"=>true];
        $jres = $serialize->serialize($res,'json');
        return new Response($jres);

    }
}