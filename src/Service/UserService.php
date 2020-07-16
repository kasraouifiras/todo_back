<?php


namespace App\Service;


use App\Manager\UserManager;
use JMS\Serializer\SerializerInterface;

class UserService
{
    private $userManager;
    private $serializer;

    public function __construct(UserManager $userManager,SerializerInterface $serializer)
    {
        $this->userManager = $userManager;
        $this->serializer = $serializer;
    }

    public function register($data){

        $deserializedData = $this->serializer->deserialize($data,'array', 'json');

        /** data validation */
        if (empty($deserializedData['email']) || empty($deserializedData['first_name']) || empty($deserializedData['last_name'] || empty($deserializedData['password']))){
            return null;
        }

        $user = $this->userManager->register($deserializedData);
        return $this->serializer->serialize($user, 'json');
    }
}