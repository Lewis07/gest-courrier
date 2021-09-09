<?php

namespace App\Form;

use App\Entity\Dossier;
use App\Entity\Courrier;
use App\Entity\TypeDossier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourrierClasserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('courrier',EntityType::class, [
                'choice_label' => 'reference',
                'class' => Courrier::class
            ])
            ->add('typDos', EntityType::class, [
                'choice_label' => 'LibelleTypeDossier',
                'class' => TypeDossier::class,
                'label' => 'Type de dossier'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dossier::class,
        ]);
    }
}
