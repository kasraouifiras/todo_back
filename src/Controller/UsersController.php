<?php


namespace App\Controller;

use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use JMS\Serializer\SerializerBuilder;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UsersController extends AbstractController
{
    /**
     * @param Response $request
     * @param UserPasswordEncoderInterface $encoder
     * @param DocumentManager $dm
     * @return Response
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, DocumentManager $dm)
    {
        $input = json_decode($request->getContent(),true);
        $serialize = SerializerBuilder::create()->build();
        if (empty($input['email']) || empty($input['first_name']) || empty($input['last_name'] || empty($input['password']))){
            $res = ["message"=>"Invalid informations","success"=>false];
            $jres = $serialize->serialize($res,'json');
            return new Response($jres,400);
        }


        $user = new User();
        $user->setPassword($encoder->encodePassword($user, $input['password']));
        $user->setEmail($input['email']);
        $user->setFirstName($input['first_name']);
        $user->setLastName($input['last_name']);
        $dm->persist($user);
        $dm->flush();


        $res = ["data"=>$user,"message"=>"User ".$user->getUsername()." successfully created","success"=>true];
        $jres = $serialize->serialize($res,'json');
        return new Response($jres);
    }


}