<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationInterface;

trait JsonResponseFormat
{
    private function getViolationsFromList($violations): array
    {
        $errorData = [];

        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $errorData[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $errorData;
    }

    private function jsonResponse(string $message, mixed $data, int $statusCode = 200): JsonResponse
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        return new JsonResponse((array)new ResponseDto($message, $data, $statusCode), $statusCode);
    }
}
