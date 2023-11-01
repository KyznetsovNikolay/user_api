<?php


namespace App\UseCase\User\Create;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class Handler
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function handle(Request $request): User
    {
        return $this->serializer->deserialize($request->getContent(), User::class, 'json');
    }
}
