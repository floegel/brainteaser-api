<?php
namespace Brainteaser\InfrastructureBundle\Repository;

use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExercise;
use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseRepository as ColoredTilesExerciseRepositoryInterface;
use Brainteaser\Domain\Exercise\ExerciseDoesNotExistException;
use Doctrine\ORM\EntityManager;

class ColoredTilesExerciseRepository implements ColoredTilesExerciseRepositoryInterface
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
     * @param string $coloredTilesExerciseId
     * @param string $trainingId
     * @return ColoredTilesExercise
     * @throws ExerciseDoesNotExistException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function get(string $coloredTilesExerciseId, string $trainingId) : ColoredTilesExercise
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('Exercise')
            ->from('ColoredTilesExercise:ColoredTilesExercise', 'Exercise')
            ->where($qb->expr()->eq('Exercise.id', ':id'))
            ->andWhere($qb->expr()->eq('Exercise.training', ':trainingId'))
            ->setParameter('id', $coloredTilesExerciseId)
            ->setParameter('trainingId', $trainingId);

        $coloredTilesExercise = $qb->getQuery()->getOneOrNullResult();
        if (is_null($coloredTilesExercise)) {
            throw new ExerciseDoesNotExistException;
        }
        return $coloredTilesExercise;
    }

    /**
     * @param string $trainingId
     * @return ColoredTilesExercise[]
     */
    public function findLastTwo(string $trainingId) : array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('Exercise')
            ->from('ColoredTilesExercise:ColoredTilesExercise', 'Exercise')
            ->where($qb->expr()->eq('Exercise.training', ':trainingId'))
            ->orderBy('Exercise.startedAt', 'DESC')
            ->setMaxResults(2)
            ->setParameter('trainingId', $trainingId);
        return $qb->getQuery()->getResult();
    }


    /**
     * @param ColoredTilesExercise $coloredTilesExercise
     */
    public function add(ColoredTilesExercise $coloredTilesExercise)
    {
        $this->entityManager->persist($coloredTilesExercise);
        $this->entityManager->flush($coloredTilesExercise);
    }
}