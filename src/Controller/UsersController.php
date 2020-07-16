<?php


namespace App\Controller;

use App\Document\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * @return Response
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request)
    {
        $user = $this->userService->register($request->getContent());
        if(is_null($user)){
            return new Response("", Response::HTTP_BAD_REQUEST);
        }
        return new Response($user);
    }


}