<?php

namespace Proglab\PrintSmarterApiClient\Form;

use Proglab\PrintSmarterApiClient\Dto\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('project_name', TextType::class, [
                'label' => 'Nom du projet',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('product_id_client', TextType::class, [
                'label' => 'ID produit client',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('product_id', ChoiceType::class, [
                'label' => 'Produit PrintSmarter',
                'attr'  => ['class' => 'form-control'],
                'choices' => [
                    'printsmartergmbh_hardcover' => 'printsmartergmbh_hardcover',
                ]
            ])
            ->add('pages', IntegerType::class, [
                'label' => 'Nombre de pages',
                'attr'  => ['class' => 'form-control', 'min' => 1],
            ])
            ->add('file_cover', UrlType::class, [
                'label' => 'URL couverture (PDF)',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('file_content', UrlType::class, [
                'label' => 'URL contenu (PDF)',
                'attr'  => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

