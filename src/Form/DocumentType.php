<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Document;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('filename', TextType::class, [
                'label' => false,
                'required' =>false
            ])
            ->add('protected', PasswordType::class, [
                'label' => 'Sécuriser avec un mot de passe ?',
                'required' => false
            ])
            ->add('allowRoles', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Gestionnaires' => 'ROLE_GESTIONNAIRE',
                    'Tous' => 'ROLE_USER'
                ],
                'required' => true,
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
            ])

            ->add('filepath', FileType::class, [
                'label' => 'Fichier...'  
            ])
        ;
        
        $builder->get('allowRoles')
        ->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
                return count($rolesArray) ? $rolesArray[0] : null;
            },
            function ($rolesString) {
                return [$rolesString];
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class
        ]);
    }
}