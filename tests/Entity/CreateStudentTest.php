<?php

namespace App\Tests\Entity;

use App\Entity\Student;
use PHPUnit\Framework\TestCase;

class CreateStudentTest extends TestCase
{
    public function testCreateStudentShouldWork(): void
    {
        $name = 'Student name';
        $grade = 10;
        $classroom = 'Student classroom';

        $student = new Student();
        $student->setName($name);
        $student->setGrade($grade);
        $student->setClassroom($classroom);

        self::assertEquals($name, $student->getName());
        self::assertEquals($grade, $student->getGrade());
        self::assertEquals($classroom, $student->getClassroom());
    }
}
