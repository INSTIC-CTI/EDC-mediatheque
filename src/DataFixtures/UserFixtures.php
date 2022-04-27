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

  public function __construct(UserPasswordHasherInterface $hasher)
  {
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

    /***** CUSTOMERS ( subscriber and no confirmed subscriber) ******/

    $userSubscriber = new User();
    $userSubscriber->setEmail('bob.fisher@gmail.com')
      ->setPassword($this->hasher->hashPassword($userSubscriber, 'bobpassword'))
      ->setRoles(["ROLE_SUBSCRIBER"])
      ->setFirstname('Bob')
      ->setLastname('Fisher')
      ->setAddress('13 rue du vieux Moulin 45000 Muche')
      ->setDateBirth(new \DateTime('1993-02-12'))
      ->setIsConfirmed(true)
      ->setDateInscription(new \DateTime('2022-04-25 15:21:00'));
    $manager->persist($userSubscriber);
    $this->addReference('Bob', $userSubscriber);

    $userNonSubscriber = new User();
    $userNonSubscriber->setEmail('jeanne.doe@test.com')
      ->setPassword($this->hasher->hashPassword($userNonSubscriber, 'azerty'))
      ->setRoles(["ROLE_SUBSCRIBER"])
      ->setFirstname('Jeanne')
      ->setLastname('Doe')
      ->setAddress('4( imapasse du jeu de boule 26000 Valence')
      ->setDateBirth(new \DateTime('1953-12-06'))
      ->setIsConfirmed(false)
      ->setDateInscription(new \DateTime('now'));
    $manager->persist($userNonSubscriber);
    $manager->flush();
  }
}
