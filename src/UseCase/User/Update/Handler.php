<?php


namespace App\UseCase\User\Update;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class Handler
{
    public function __construct(private UserRepository $repository, private SerializerInterface $serializer)
    {
    }

    public function handle(Request $request): User
    {

        /** @var User $newUserData */
        if (!$user = $this->repository->findOneBy(['id' => $request->get('id')])) {
            throw new \Exception('User not found');
        }

        $updateUser = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $user
            ->setEmail($updateUser->getemail() ?? $user->getEmail())
            ->setName($updateUser->getName() ?? $user->getName())
            ->setAge($updateUser->getAge() ?? $user->getAge())
            ->setSex($updateUser->getSex() ?? $user->getSex())
            ->setBirthday($updateUser->getBirthday() ?? $user->getBirthday())
            ->setPhone($updateUser->getPhone() ?? $user->getPhone());

        return $user;
    }
}
