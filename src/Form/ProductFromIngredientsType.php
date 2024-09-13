<?php
namespace App\Form;

use App\Entity\Product;
use App\Entity\Ingrediant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFromIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Product Name',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price',
            ])
            ->add('image', TextType::class, [
                'label' => 'Image URL',
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingrediant::class,  // Assure-toi que le nom de la classe est correct
                'choice_label' => 'name',      // Attribut affiché dans la liste déroulante
                'multiple' => true,            // Permet la sélection multiple d'ingrédients
                'expanded' => false,           // Utilise une liste déroulante (false) ou des cases à cocher (true)
                'label' => 'Select Ingredients'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class, // Liaison avec l'entité Product
        ]);
    }
}
