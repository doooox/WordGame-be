<?php

namespace App\Repository;

use App\Entity\WordTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WordTest>
 *
 * @method WordTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordTest[]    findAll()
 * @method WordTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordTest::class);
    }

    public function save(WordTest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WordTest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
