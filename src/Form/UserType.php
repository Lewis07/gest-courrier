<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;

class UserType extends AbstractType
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
//            'label' => false,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, $this->getConfiguration("Nom", "Nom d'utilisateur..."))
            ->add('prenom',TextType::class, $this->getConfiguration("Prenom", "Prenom d'utilisateur..."))
            ->add('telephone',TextType::class, $this->getConfiguration("Numero Telephone", "+261..."))
            ->add('email',EmailType::class, $this->getConfiguration("email", "Adresse email..."))
            ->add('adresse',TextType::class, $this->getConfiguration("Adresse", "Lot..."))
            ->add('fonction',TextType::class, $this->getConfiguration("Fonction", "Fonction..."))
            ->add('username',TextType::class, $this->getConfiguration("Username", "Surnom"))
            ->add('password',PasswordType::class, $this->getConfiguration("Mot de passe", "Mot de passe..."))
            ->add('confirm_password',PasswordType::class, $this->getConfiguration("Confirmation du mot de passe", "Répétez votre mot de passe..."));
//            ->add('Roles', ChoiceType::class, [
//                'required' => true,
//                'multiple' => false,
//                'expanded' => false,
//                'label' => 'Rôles',
//                'choices'  => [
//                    'Administrateur ' => 'ROLE_ADMIN',
//                    'Utilisateur' => 'ROLE_USER',
//                ],
//            ]);

            // Data transformer
//        $builder->get('Roles')
//        ->addModelTransformer(new CallbackTransformer(
//            function ($rolesArray) {
//                 // transform the array to a string
//                 return count($rolesArray)? $rolesArray[0]: null;
//            },
//            function ($rolesString) {
//                 // transform the string back to an array
//                 return [$rolesString];
//            }
//    ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
