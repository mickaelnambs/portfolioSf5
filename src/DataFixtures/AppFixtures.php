<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\Entity\Medias;
use App\Entity\Skills;
use App\Entity\Formations;
use App\Entity\References;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $userPasswordEncoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $admin = new Users();
        $admin->setPassword($this->userPasswordEncoder->encodePassword($admin, "password"));
        $admin->setEmail("admin@email.com");
        $manager->persist($admin);

        for ($i = 1; $i <= 5; $i++) {
            $reference = new References();
            $reference->setTitle("Reference " . $i);
            $reference->setCompany("Company " . $i);
            $reference->setDescription("Description " . $i);
            $reference->setStartedAt(new \DateTimeImmutable("10 years ago"));
            $reference->setEndedAt(new \DateTimeImmutable("8 years ago"));
            $media = new Medias();
            $media->setPath("uploads/image.png");
            $reference->addMedia($media);
            $manager->persist($reference);

            $skill = new Skills();
            $skill->setLevel(rand(1, 10));
            $skill->setName("Skill " . $i);
            $manager->persist($skill);

            $formation = new Formations();
            $formation->setGradeLevel(rand(0, 5));
            $formation->setDescription("Description " . $i);
            $formation->setSchool("School " . $i);
            $formation->setName("Formation " . $i);
            $formation->setStartedAt(new \DateTimeImmutable("10 years ago"));
            $formation->setEndedAt(new \DateTimeImmutable("8 years ago"));
            $manager->persist($formation);
        }

        $manager->flush();
    }
}