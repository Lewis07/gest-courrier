<?php

namespace App\Form;

use App\Entity\PartageCourrier;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartageCourrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recepteur_courrier_partage',EntityType::class, [
                'mapped' => false,
                'class' => User::class,
                'multiple' => true,
                'expanded' => false,
                'choice_label' => 'email',
                'label' => 'Recepteur',
                'query_builder' => function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('u')
                                            ->orderBy('u.id','ASC')
                                            ;
                },
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PartageCourrier::class,
        ]);
    }
}
