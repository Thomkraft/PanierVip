<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ShoppingList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\Callback;

class ShoppingListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name of your list',
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('listedProducts', CollectionType::class, [
                'entry_type' => ListedProductType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'constraints' => [
                    new Count(['min' => 1]),
                    new Callback($this->validateUniqueProducts(...))
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShoppingList::class,
        ]);
    }

    public function validateUniqueProducts($listedProducts,ExecutionContextInterface $context): void
    {
        $productNames = [];

        foreach ($listedProducts as $key => $listedProduct) {
            $productName = $listedProduct->getProduct()->getName();

            if (in_array($productName, $productNames)) {
                $context->buildViolation("Each product must be unique in the list.")
                    ->atPath("listedProducts.product") // Associe l'erreur au champ "product"
                    ->addViolation();
            }

            $productNames[] = $productName;
        }
    }
}
