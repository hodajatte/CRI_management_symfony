<?php

namespace App\Form;

use App\Entity\Societe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raison_sociale')
            ->add('source')
            ->add('forme_juridique')
            ->add('secteur_activite')
            ->add('sous_secteur_activite')
            ->add('produit')
            ->add('offre_service')
            ->add('date_creation', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('gsm')
            ->add('email')
            ->add('site_internet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Societe::class,
        ]);
    }
}
