<?php

namespace App\Controller;

use App\Entity\User;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterUserController extends AbstractController
{
    use JsonResponseFormat;

    #[Route(path: "/api/auth/register", methods: ["POST"])]
    #[OA\Tag(name: 'auth')]
    #[OA\Post(description: "Create a user")]
    #[OA\RequestBody(
        description: "Json to create the user",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "email",
                    type: "string",
                    example: "example@email.com"
                ),
                new OA\Property(
                    property: "password",
                    type: "string",
                    example: "testpassword"
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns the email of the user',
        content: new OA\JsonContent(ref: new Model(type: ResponseDto::class))
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid inputs',
        content: new OA\JsonContent(ref: new Model(type: ResponseDto::class))
    )]
    public function register(
        UserRepository $userRepository,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasherInterface,
        ValidatorInterface $validatorInterface
    ): JsonResponse {
        $jsonParams = json_decode($request->getContent(), true);

        $user = new User();

        if (
            null === $jsonParams['password']
            || '' === $jsonParams['password']
            || strlen($jsonParams['password']) < 5
        ) {
            return $this->jsonResponse(
                'Password not valid',
                ['password' => $jsonParams['password']],
                400
            );
        }

        $hashedPassword = $userPasswordHasherInterface->hashPassword($user, $jsonParams['password']);

        $user->setEmail($jsonParams['email']);
        $user->setUsername($jsonParams['email']);
        $user->setPassword($hashedPassword);

        $violations = $validatorInterface->validate($user);

        if (count($violations)) {
            return $this->jsonResponse(
                'Invalid inputs',
                $this->getViolationsFromList($violations),
                400
            );
        }

        $userRepository->save($user, true);

        return $this->json((array)new ResponseDto(
            'User created successfully',
            ['email' => $user->getEmail()]
        ), 201);
    }
}
