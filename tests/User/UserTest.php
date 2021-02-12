<?php


namespace App\Tests\User;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testAddUser()
    {
        $user = new User();
        $user->setEmail("test@test.fr");
        $user->setPassword("test");
        $user->setRoles(["ROLE_USER"]);

        $this->assertSame("test@test.fr", $user->getEmail());
        $this->assertSame("test", $user->getPassword());
        $this->assertSame(["ROLE_USER"], $user->getRoles());
    }


}
