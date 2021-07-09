<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;
use App\DataFixtures\ProjectFixtures;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i=1; $i < 401; $i++) { 
            $task = new Task();
            $task->setName("Task : $i");
            $task->setDescription("Description of task $i");
            $task->setCreationDate(new \DateTime());
            $task->setDueDate(new \DateTime("2021-12-20"));
            $task->setIsArchived(mt_rand(0,1));
            $randomProject = "project" . mt_rand(1,40);
            $task->setProject($this->getReference($randomProject));
            $manager->persist($task);
        }
        

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProjectFixtures::class,
        ];
    }
}
