<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Societe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('tele')
            ->add('email')
            ->add('evenement')
            ->add('dateVisite', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('formation')
            ->add('societe', EntityType::class, [
                'class' => Societe::class,
                'choice_label' => 'raison_sociale',
                'multiple' => false,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
