<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

  /**
   * @var UserPasswordHasherInterface
   */
  private $hasher;

  public function __construct(UserPasswordHasherInterface $hasher){
    $this->hasher = $hasher;
  }


    public function load(ObjectManager $manager): void
    {
        /***** ADMIN ******/

        $userAdmin = new User();
        $userAdmin->setEmail('Johny.doe@la-reserve.com')
        ->setPassword($this->hasher->hashPassword($userAdmin, 'bonjourlareserve'))
        ->setRoles(['ROLE_ADMIN'])
        ->setFirstname('Johny')
        ->setLastname('doe')
        ->setAddress('8 rue de la victimisation 43800 Le-Boulier')
        ->setDateBirth(new \DateTime('1982-05-06'))
        ->setIsConfirmed(true)
        ->setDateInscription(new \DateTime('2021-05-12 12:32:45'));      
        $manager->persist($userAdmin);
        $manager->flush();
    }
}