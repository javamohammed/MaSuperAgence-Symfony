<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface  $encoder)
    {
        $this->encoder = $encoder;

    }
    public function load(ObjectManager $manager)
    {

         $user = new \App\Entity\User();
         $user->setUsername('demo');
         //$user->setPassword($this->encoder->encodePassword($user, 'demo') );
         $encoded = $this->encoder->encodePassword($user, 'demo');
         $user->setPassword($encoded );
         $manager->persist($user);

        $manager->flush();
    }
}
