<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CreateUserTest extends TestCase
{
    public function testCreateUserShouldWork(): void
    {
        $email = 'User email';
        $username = 'User name';

        $user = new User();
        $user->setEmail($email);
        $user->setUsername($username);

        self::assertEquals($email, $user->getEmail());
        self::assertEquals($username, $user->getUsername());
    }
}
