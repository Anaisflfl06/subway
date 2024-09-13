<?php

namespace App\Form;

use App\Entity\RecipeIngrediant;
use App\Entity\Ingrediant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeIngrediantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Sélection de l'ingrédient via une liste déroulante
            ->add('ingredient', EntityType::class, [
                'class' => Ingrediant::class,  // L'entité à utiliser pour ce champ
                'choice_label' => 'name',  // Affiche le nom de l'ingrédient dans la liste
                'label' => 'Ingredient',
                'placeholder' => 'Select an ingredient',
                'attr' => ['class' => 'form-control']
            ])
            // Quantité de l'ingrédient (en unités ou grammes par exemple)
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantity',
                'attr' => [
                    'min' => 1,  // Quantité minimale
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeIngrediant::class,  // Associe le formulaire à l'entité RecipeIngrediant
        ]);
    }
}
