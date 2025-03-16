<?php

namespace App\Form;

use App\Entity\ListedProduct;
use App\Entity\Product;
use App\Entity\ShoppingList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListedProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'label' => false,
            ])
            ->add('quantity', IntegerType::class, [
                'label' => false,
            ])
            ->add('bought', CheckboxType::class, [
                'label' => false,
                'required' => false,
            ]);
//            ->add('shoppingList', EntityType::class, [
//                'class' => ShoppingList::class,
//                'choice_label' => 'id',
//            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListedProduct::class,
        ]);
    }
}
