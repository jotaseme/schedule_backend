<?php

namespace App\Infrastructure\Repository;

use App\Domain\Schedule\Block;
use App\Domain\Schedule\BlockRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class UserRepository
 * @package App\Infrastructure\Repository
 */
class BlockRepository extends ServiceEntityRepository implements BlockRepositoryInterface
{
    private FilterBuilderUpdaterInterface $filterBuilderUpdater;

    private FormInterface $form;

    public function __construct(
        ManagerRegistry $registry, FilterBuilderUpdaterInterface $filterBuilderUpdater, FormInterface $blockFilter
    )
    {
        $this->form                 = $blockFilter;
        $this->filterBuilderUpdater = $filterBuilderUpdater;
        parent::__construct($registry, Block::class);
    }

    /**
     * @inheritDoc
     */
    public function getAllByUserQb(string $email): QueryBuilder
    {
        return $this->createQueryBuilder('block')
            ->join('block.user', 'user')
            ->where('user.email = :email')
            ->setParameter('email', $email);
    }


    /**
     * @param array $criteria
     * @param string $email
     * @return iterable
     */
    public function filter(array $criteria, string $email): iterable
    {
        $this->form->submit($criteria);
        $filterBuilder = $this->getAllByUserQb($email);
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->filterBuilderUpdater->addFilterConditions($this->form, $filterBuilder);

        return $queryBuilder->getQuery()->getResult();
    }
}
