<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckInstanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Titel'])
            ->add('checklist')
            ->add('user', null, ['label' => 'Benutzer'])
            ->add('customer', null, ['label' => 'Kunde'])
            ->add('domain', UrlType::class, ['required' => false])
            ->add('date', DateTimeType::class, [
                'date_format' => 'd.M.y',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'label' => 'Datum'
            ])
            ->add('deadline', DateTimeType::class, [
                'date_format' => 'd.M.y',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
                'data' => null
            ])
            ->add('assignedUser', null, ['label' => 'zuständiger Mitarbeiter'])
            ->add('info')
            ->add('save', SubmitType::class, ['label' => '<i class="uk-icon-save"></i> Speichern'])
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
