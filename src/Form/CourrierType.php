<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Courrier;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CourrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('DateEnvoie')
            ->add('recipient', EntityType::class, [
                "class" => User::class,
                "choice_label" => "email",
            ])
            ->add('priorite', ChoiceType::class, [
                'label' => 'Priorité ',
                    'choices'  => [
                        'Normale' => null,
                        'Urgent' => true,
                        'Très urgent' => false,
                    ],
                // 'expanded' => false,
                // 'multiple' => false,
            ])
            ->add('typeCourrier',TextType::class,[
                'label' => 'Type de courrier'
            ])
            ->add('objetCourrier',TextType::class,[
                'label' => 'Objet'
            ])
            ->add('message', CKEditorType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('fichier',FileType::class,[
                'label' => 'Fichier',
                'required' => false,
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Courrier::class,
        ]);
    }
}
