<?php

namespace Proglab\PrintSmarterApiClient\Form;

use Proglab\PrintSmarterApiClient\Dto\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, [
                'label' => 'Prénom',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Nom',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('company', TextType::class, [
                'label'    => 'Entreprise',
                'required' => false,
                'attr'     => ['class' => 'form-control'],
            ])
            ->add('address1', TextType::class, [
                'label' => 'Adresse (ligne 1)',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('address2', TextType::class, [
                'label'    => 'Adresse (ligne 2)',
                'required' => false,
                'attr'     => ['class' => 'form-control'],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('zip', TextType::class, [
                'label' => 'Code postal',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('country_code', TextType::class, [
                'label' => 'Code pays (ex: FR)',
                'attr'  => ['class' => 'form-control', 'maxlength' => 2],
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr'  => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}

