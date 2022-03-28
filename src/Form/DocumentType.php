<?php

namespace App\Form;

use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('allowRoles', CheckboxType::class, [
                'label' => false,
                'Value' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Gestionnaires' => 'ROLE_GESTIONNAIRE',
                    'Tous' => 'ROLE_USER'
                ],
                'required' => true,
            ])
            ->add('categories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class
        ]);
    }
}