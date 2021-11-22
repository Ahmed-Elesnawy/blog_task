<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
         $user->setEmail('admin@admin.com');
         $password = '123456';
         $encoded = $this->encoder->encodePassword($user, $password);
         $user->setPassword($encoded);
         $manager->persist($user);
         $manager->flush();
    }
}
