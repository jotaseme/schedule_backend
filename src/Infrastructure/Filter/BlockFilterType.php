<?php

namespace App\Infrastructure\Filter;

use App\Domain\Shared\Transformer\Date\DatetimeTransformerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BlockFilterType extends AbstractType
{
    private DatetimeTransformerInterface $datetimeTransformer;

    /**
     * @param DatetimeTransformerInterface $datetimeTransformer
     */
    public function __construct(DatetimeTransformerInterface $datetimeTransformer)
    {
        $this->datetimeTransformer = $datetimeTransformer;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', TextType::class, [
                'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                    if (!$values['value'] || !$field) {
                        return null;
                    }

                    $query = $filterQuery->getQueryBuilder();
                    if ($date = $this->datetimeTransformer->transformToObject($values['value'])) {
                        $query->andWhere("block.date >= :from");
                        $query->setParameter('from', $date);
                    } else {
                        $query->andWhere("1 = 0");
                    }
                }
            ])
            ->add('to', TextType::class, [
                'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                    if (!$values['value'] || !$field) {
                        return null;
                    }

                    $query = $filterQuery->getQueryBuilder();
                    if ($date = $this->datetimeTransformer->transformToObject($values['value'])) {
                        $query->andWhere("block.date <= :to");
                        $query->setParameter('to', $date);
                    } else {
                        $query->andWhere("1 = 0");
                    }
                }
            ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'filter_block';
    }
}
