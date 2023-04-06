<?php

namespace App\Entity;

use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StudentRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?int $grade = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $classroom = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGrade(): ?int
    {
        return $this->grade;
    }

    public function setGrade(int $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getClassroom(): ?string
    {
        return $this->classroom;
    }

    public function setClassroom(string $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }
}
