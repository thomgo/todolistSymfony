<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const POSITIONS = ["employee", "manager", "buyer", "assistant", "office manager"];
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i=1; $i < 6; $i++) { 
            $user = new User();
            $user->setEmail("user$i@gmail.com");
            $password = $this->encoder->encodePassword($user, "password$i");
            $user->setPassword($password);
            $user->setFirstname("User$i firstname");
            $user->setLastname("User$i laststname");
            $user->setAge(mt_rand(18, 60));
            $user->setPosition(self::POSITIONS[array_rand(self::POSITIONS)]);
            $this->addReference("user$i", $user);
            $manager->persist($user);
        }
        

        $manager->flush();
    }
}
