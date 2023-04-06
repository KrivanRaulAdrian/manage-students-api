<?php

namespace App\Controller;

use App\Entity\Student;
use OpenApi\Attributes as OA;
use App\Repository\StudentRepository;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: "api/v1")]
#[OA\Tag(name: 'student')]
class StudentController extends AbstractController
{
    use JsonResponseFormat;

    #[Route(path: "/students", methods: ["POST"])]
    #[OA\Post(description: "Create student")]
    #[OA\RequestBody(
        description: "Json to create the student",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "Raul"
                ),
                new OA\Property(
                    property: "grade",
                    type: "integer",
                    example: "10"
                ),
                new OA\Property(
                    property: "classroom",
                    type: "string",
                    example: "Computer Science"
                )
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns the ID of the student',
        content: new OA\JsonContent(ref: new Model(type: ResponseDto::class))
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid inputs',
        content: new OA\JsonContent(ref: new Model(type: ResponseDto::class))
    )]
    public function create(
        Request $request,
        StudentRepository $studentRepository,
        ValidatorInterface $validatorInterface
    ): Response {
        $jsonParams = json_decode($request->getContent(), true);

        $student = new Student();

        if (!is_numeric($jsonParams['grade'])) {
            return $this->jsonResponse(
                'Invalid grade format, please enter only numbers',
                ['grade' => $jsonParams['grade']],
                400
            );
        } elseif (10 < $jsonParams['grade'] || 1 > $jsonParams['grade']) {
            return $this->jsonResponse('Invalid format, 
            please enter a grade between 1 and 10', ['grade' => $jsonParams['grade']], 400);
        }

        $student->setName($jsonParams['name']);
        $student->setGrade($jsonParams['grade']);
        $student->setClassroom($jsonParams['classroom']);

        $violations = $validatorInterface->validate($student);

        if (count($violations)) {
            return $this->jsonResponse(
                'Invalid inputs',
                $this->getViolationsFromList($violations),
                400
            );
        }

        $studentRepository->save($student, true);

        $data = ['id' => (string)$student->getId()];

        return $this->jsonResponse('Student created successfully', $data, 201);
    }
    #[Route(path: "/students/{id}", methods: ["GET"])]
    #[OA\Get(description: "Return a student by its ID")]
    public function findById(
        StudentRepository $studentRepository,
        string $id,
        SerializerInterface $serializerInterface
    ): Response {
        $student = $studentRepository->find($id);

        if ($student === null) {
            return $this->jsonResponse('Student not found', ['id' => $id], 404);
        }

        $json = $serializerInterface->serialize($student, 'json');

        return $this->jsonResponse('Student by ID', $json);
    }
    #[Route(path: "/students", methods: ["GET"])]
    #[OA\Get(description: "Return all students")]
    public function findAll(
        StudentRepository $studentRepository,
        SerializerInterface $serializerInterface
    ): Response {
        $students = $studentRepository->findAll();

        $json = $serializerInterface->serialize($students, 'json');

        return $this->jsonResponse('List of students', $json);
    }
    #[Route(path: "/students/{id}", methods: ["PUT"])]
    #[OA\Put(description: "Update a student by its ID")]
    #[OA\RequestBody(
        description: "Json to update the student",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "Alex"
                ),
                new OA\Property(
                    property: "grade",
                    type: "integer",
                    example: "10"
                ),
                new OA\Property(
                    property: "classroom",
                    type: "string",
                    example: "Art"
                )
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the ID of the company',
        content: new OA\JsonContent(ref: new Model(type: ResponseDto::class))
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid inputs',
        content: new OA\JsonContent(ref: new Model(type: ResponseDto::class))
    )]
    public function update(
        StudentRepository $studentRepository,
        Request $request,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface,
        string $id
    ): Response {
        $student = $studentRepository->find($id);

        if ($student === null) {
            return $this->jsonResponse('Student not found', ['id' => $id], 404);
        }

        $jsonParams = json_decode($request->getContent(), true);

        $student->setName($jsonParams['name']);
        $student->setGrade($jsonParams['grade']);
        $student->setClassroom($jsonParams['classroom']);

        $violations = $validatorInterface->validate($student);

        if (count($violations)) {
            return $this->jsonResponse(
                'Invalid inputs',
                $this->getViolationsFromList($violations),
                400
            );
        }

        $studentRepository->save($student, true);

        $json = $serializerInterface->serialize($student, 'json');

        return $this->jsonResponse('Student updated successfully', $json);
    }
    #[Route(path: "/students/{id}", methods: ["DELETE"])]
    #[OA\Delete(description: "Delete a student by its ID")]
    public function delete(StudentRepository $studentRepository, string $id): Response
    {
        $student = $studentRepository->find($id);

        if ($student === null) {
            return $this->jsonResponse('Student not found', ['id' => $id], 404);
        }

        $studentRepository->remove($student, true);

        return $this->jsonResponse('Student deleted successfully', []);
    }
}
