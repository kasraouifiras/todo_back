<?php


namespace App\Manager;


use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $dm;
    private $encoder;

    public function __construct(DocumentManager $dm,UserPasswordEncoderInterface $encoder)
    {
        $this->dm = $dm;
        $this->encoder = $encoder;
    }

    public function getUserRepository(){
        return $this->dm->getRepository(User::class);
    }

    public function register($data){
        $user = new User();
        $user->setPassword($this->encoder->encodePassword($user, $data['password']))
            ->setEmail($data['email'])
            ->setFirstName($data['first_name'])
            ->setLastName($data['last_name']);

        $this->dm->persist($user);
        $this->dm->flush();

        return $user;
    }


}