<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Wish;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subjectId', HiddenType::class)
            ->add('chosenGroups', TextType::class, [
                'label' => 'Nombre de groupe(s)',
            ])

        ->add('groupeType', EntityType::class, [
        'class' => Group::class,
        'choice_label' => 'type',
        'query_builder' => function (EntityRepository $entityRepository) {
            return $entityRepository->createQueryBuilder('g')
                ->orderBy('g.type', 'ASC');
        },
        'label' => 'Groupe',
        'attr' => [
            'class' => 'form-select',
            'label' => 'Groupe',
        ],
        'multiple' => false,
        ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ],
                'label' => 'Créer un voeu',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
