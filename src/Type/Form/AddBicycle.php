<?php

namespace App\Type\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Document\Bicycle;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBicycle extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('color', TextType::class)
            ->add('brand', TextType::class)
            ->add('status')
            ->add('currentSpeed')
            ->add('accelerateStatus')
            ->add('geolocation');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bicycle::class,
            'csrf_protection' => false
        ]);
    }
}
