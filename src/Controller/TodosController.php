<?php


namespace App\Controller;

use App\Document\Todo;
use App\Service\TodoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{

    private $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }


    /**
     * @Route("/api/todos", name="show_todos", methods={"GET"})
     */
    public function showAll()
    {
        $todos = $this->todoService->getAll();
        if(is_null($todos)){
            return new Response("",Response::HTTP_NOT_FOUND);
        }
        return new Response($todos);
    }


    /**
     * @Route("/api/todos/byuser", name="show_todos_byuser", methods={"GET"})
     */
    public function showUserTodos()
    {
        $todos = $this->todoService->getUserTodos($this->getUser()->getId());
        if(is_null($todos)){
            return new Response("",Response::HTTP_NOT_FOUND);
        }
        return new Response($todos);
    }

    /**
     * @param $id
     * @Route("/api/todos/{id}", name="show_todo", methods={"GET"})
     */
    public function show($id)
    {
        $todo = $this->todoService->get($id);
        if(is_null($todo)){
            return new Response("",Response::HTTP_NOT_FOUND);
        }
        return new Response($todo);
    }


    /**
     * @param Request $request
     * @Route("/api/todos", name="add_todo", methods={"POST"})
     */
    public function post(Request $request)
    {
        $todo = $this->todoService->post($request->getContent(),$this->getUser()->getId());
        return new Response($todo);
    }

    /**
     * @Route("/api/todos/{id}", name="update_todo", methods={"PUT","PATCH"})
     */
    public function update(Request $request,$id)
    {
        $todo = $this->todoService->update($request->getContent(),$id);
        if(is_null($todo)){
            return new Response("",Response::HTTP_NOT_FOUND);
        }
        return new Response($todo);
}

    /**
     * @Route("/api/todos/{id}", name="delete_todo", methods={"DELETE"})
     */
    public function delete($id)
    {
        $deleted = $this->todoService->delete($id);
        if(!$deleted){
            return new Response("",Response::HTTP_NOT_FOUND);
        }
        return new Response($deleted);
    }
}