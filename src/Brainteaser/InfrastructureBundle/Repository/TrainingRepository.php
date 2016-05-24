<?php
namespace Brainteaser\InfrastructureBundle\Repository;

use Brainteaser\Domain\Training\Training;
use Brainteaser\Domain\Training\TrainingDoesNotExistException;
use Brainteaser\Domain\Training\TrainingRepository as TrainingRepositoryInterface;
use Doctrine\ORM\EntityManager;

class TrainingRepository implements TrainingRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $id
     * @return Training
     * @throws TrainingDoesNotExistException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function get(string $id) : Training
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('Training')
           ->from('Training:Training', 'Training')
           ->where($qb->expr()->eq('Training.id', ':id'))
           ->setParameter('id', $id);

        $training = $qb->getQuery()->getOneOrNullResult();
        if (is_null($training)) {
            throw new TrainingDoesNotExistException;
        }
        return $training;
    }

    /**
     * @return Training[]
     */
    public function findHighscores() : array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('Training')
            ->from('Training:Training', 'Training')
            ->where($qb->expr()->isNotNull('Training.finishedAt'))
            ->orderBy('Training.score', 'DESC')
            ->setMaxResults(10);
        return $qb->getQuery()->getResult();
    }

    /**
     * @param Training $training
     */
    public function add(Training $training)
    {
        $this->entityManager->persist($training);
        $this->entityManager->flush($training);
    }
}