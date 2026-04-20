<?php

namespace Proglab\PrintSmarterApiClient\Form;

use Proglab\PrintSmarterApiClient\Dto\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('order_id_client', TextType::class, [
                'label' => 'Référence commande client',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('shipping_code', ChoiceType::class, [
                'label' => 'Code livraison (ex: Standard)',
                'attr'  => ['class' => 'form-control'],
                'choices' => [
                    'Standard' => 'Standard',
                    'Express' => 'Express',
                ]
            ])
            ->add('shipping_address', AddressType::class, [
                'label' => false,
            ])
            ->add('return_address', AddressType::class, [
                'label' => false,
            ])
            ->add('products', CollectionType::class, [
                'entry_type'    => ProductType::class,
                'entry_options' => ['label' => false],
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
                'label'         => false,
                'attr'          => ['class' => 'products-collection'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}

