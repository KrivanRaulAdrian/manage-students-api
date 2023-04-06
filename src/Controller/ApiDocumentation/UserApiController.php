<?php

namespace App\Controller\ApiDocumentation;

use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

class UserApiController
{
    #[Route(path: "/api/login_check", methods: ["POST"])]
    #[OA\Post(description: "Login route")]
    #[OA\Tag(name: 'auth')]
    #[OA\RequestBody(
        description: "Payload to authenticate the user",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "username", type: "string", example: "user@gmail.com"),
                new OA\Property(property: "password", type: "string", example: "passwordexample"),
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Login response containing the token",
        content: new OA\JsonContent(
            properties: [new OA\Property(property: "token", type: "string")]
        )
    )]
    public function login(): void
    {
    }
}
