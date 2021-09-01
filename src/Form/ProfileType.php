<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Fonction;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ProfileType extends AbstractType
{
    /**
     * permet d'avoir la configuration de base d'un champ !
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder){
        return[
           'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, $this->getConfiguration("Nom", "Nom ..."))
            ->add('prenom', TextType::class, $this->getConfiguration("Prenom", "Prenom d'utilisateur..."))
            ->add('telephone', TextType::class, $this->getConfiguration("Numero Telephone", "+261..."))
            ->add('email', EmailType::class, $this->getConfiguration("email", "Adresse email..."))
            ->add('adresse', TextType::class, $this->getConfiguration("Adresse", "Lot..."))
            ->add('fonction',EntityType::class, [
                'class' => Fonction::class,
                'choice_label' => 'nomFonction'
            ])
            ->add('departement',EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'nomDepartement'
            ])
            ->add('username', TextType::class, $this->getConfiguration("Nom d'utilisateur", "Surnom"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
