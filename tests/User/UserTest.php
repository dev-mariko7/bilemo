<?php


namespace App\Tests\User;


use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testAddUser()
    {
        $user = new User();
        $user->setEmail("test@test.fr");
        $user->setPassword("test");
        $user->setRoles(["ROLE_USER"]);

        $this->assertEquals($user, $user);
    }


}
