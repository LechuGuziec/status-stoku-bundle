<?php

namespace LechuGuziec\StatusStokuBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use LechuGuziec\StatusStokuBundle\Entity\StatusStoku;

/**
 * @extends ServiceEntityRepository<StatusStoku>
 */
final class StatusStokuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusStoku::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findLatest(): ?StatusStoku
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.updatedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
