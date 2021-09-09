<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Courrier;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValidationCourrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipient', EntityType::class, [
                "class" => User::class,
                "choice_label" => "email",
                "query_builder" => function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.roles NOT LIKE :role')
                        ->setParameter('role', '%"'.'ROLE_DIRECTEUR'.'"%');
                }
            ])
            ->add('typeCourrier',TextType::class,[
                'label' => 'Type de courrier'
            ])
            ->add('message', CKEditorType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('priorite', ChoiceType::class, [
                'label' => 'Priorité ',
                'choices'  => [
                    'Normale' => 1,
                    'Urgent' => 2,
                    'Très urgent' => 3,
                ],
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
