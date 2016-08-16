<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Aufgabe'])
            ->add('description', null, ['label' => 'Beschreibung'])
        ;

        if ($options['checklist'] === null) {
            $builder->add('checklist', null, ['label' => 'Checkliste', 'required' => true]);
        }

        $builder
            ->add('taskCategory', null, ['label' => 'Kategorie'])
            ->add('orderNum', null, ['label' => 'Reihenfolge'])
            ->add('save', SubmitType::class, ['label' => '<i class="uk-icon-save"></i> Speichern'])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Task',
            'checklist' => null
        ));
    }
}
