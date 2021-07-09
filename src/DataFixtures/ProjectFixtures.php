<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Project;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\DataFixtures\UserFixtures;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i=1; $i < 41; $i++) { 
            $project = new Project();
            $project->setName("Project : $i");
            $project->setDescription("Description of project $i");
            $project->setCreationDate(new \DateTime());
            $project->setDueDate(new \DateTime("2022-05-26"));
            $project->setIsArchived(mt_rand(0,1));
            $randomUser = "user" . mt_rand(1,5);
            $project->addUser($this->getReference($randomUser));
            $this->addReference("project$i", $project);
            $manager->persist($project);
        }
        

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
