<?php

namespace App\Controller;

use OpenApi\Attributes as OA;

class ResponseDto
{
    public function __construct(
        #[OA\Property(property: "message", type: "string", example: "Resource created/updated")]
        public readonly string $message,
        #[OA\Property(property: "data", type: "object")]
        public readonly array $data,
        #[OA\Property(property: "statusCode", type: "integer", example: 200)]
        public readonly int $statusCode = 201,
    ) {
    }
}
