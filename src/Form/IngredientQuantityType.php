<?php
// src/Form/IngredientQuantityType.php

namespace App\Form;

use App\Entity\Ingrediant; // Assuming your entity is called Ingrediant
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class IngredientQuantityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ingredient', EntityType::class, [
                'class' => Ingrediant::class, // Entity class for ingredients
                'choice_label' => 'name', // Property to display in the dropdown
                'label' => 'Ingredient',
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantity',
                'required' => true, // Set this to true if you want this field to be required
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'validation_groups' => null, // Use default validation groups if needed
        ]);
    }
}
