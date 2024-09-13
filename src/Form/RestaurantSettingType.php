<?php

namespace App\Form;

use App\Entity\RestaurantSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantSettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('weekOpeningTime', TextType::class, ['required' => false])
            ->add('weekClosingTime', TextType::class, ['required' => false])
            ->add('weekendOpeningTime', TextType::class, ['required' => false])
            ->add('weekendClosingTime', TextType::class, ['required' => false])
            ->add('generalName', TextType::class, ['required' => false])
            ->add('address', TextType::class, ['required' => false])
            ->add('phoneNumber', TextType::class, ['required' => false])
            ->add('email', TextType::class, ['required' => false])
            ->add('website', TextType::class, ['required' => false])
            ->add('serviceType', TextType::class, ['required' => false])
            ->add('reservationPolicy', TextareaType::class, ['required' => false])
            ->add('returnPolicy', TextareaType::class, ['required' => false])
            ->add('paymentOptions', ChoiceType::class, [
                'choices' => [
                    'Credit Card' => 'credit_card',
                    'Cash' => 'cash',
                    'PayPal' => 'paypal',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('cuisineTypes', TextType::class, ['required' => false])
            ->add('breakfastHours', TextType::class, ['required' => false])
            ->add('lunchHours', TextType::class, ['required' => false])
            ->add('dinnerHours', TextType::class, ['required' => false])
            ->add('specialMenus', TextareaType::class, ['required' => false])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RestaurantSetting::class,
        ]);
    }
}
