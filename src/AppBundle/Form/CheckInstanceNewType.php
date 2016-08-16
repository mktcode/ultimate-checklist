<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('title', null, ['attr' => ['class' => 'uk-form-large'], 'label' => 'Projekt/Titel'])
            ->add('customer', null, ['label' => 'Kunde'])
            ->add('domain', UrlType::class, ['required' => false])
            ->add('assignedUser', null, ['label' => 'zuständiger Mitarbeiter'])
            ->add('sendMail', CheckboxType::class, ['label' => 'per E-Mail benachrichtigen?', 'mapped' => false, 'required' => false])
            ->add('deadline', DateTimeType::class, [
                'date_format' => 'd.M.y',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
                'data' => null
            ])
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
