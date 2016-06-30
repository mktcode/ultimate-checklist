<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckInstanceNewType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['attr' => ['class' => 'uk-form-large'], 'label' => 'Titel'])
            ->add('customer', null, ['label' => 'Kunde'])
            ->add('domain', UrlType::class)
            ->add('assignedUser', null, ['label' => 'zuständiger Mitarbeiter'])
            ->add('info')
            ->add('save', SubmitType::class, ['label' => 'Check starten <i class="uk-icon-angle-right"></i>'])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CheckInstance'
        ));
    }
}
