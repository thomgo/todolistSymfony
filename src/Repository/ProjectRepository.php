<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function findProjectsByDate(User $user, bool $isArchived = false):Array
    {
        return $this->createQueryBuilder('p')
            ->innerjoin("p.users", 'u')
            ->addSelect("u")
            ->where("p.isArchived = :isArchived")
            ->setParameter('isArchived', $isArchived)
            ->andWhere('u = :user')
            ->setParameter('user', $user)
            ->orderBy('p.dueDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findProjectWithTasks(int $id): ?Project
    {
        return $this->createQueryBuilder('p')
            ->leftJoin("p.tasks", "t")
            ->addSelect("t")
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->orderBy("t.dueDate", "ASC")
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
