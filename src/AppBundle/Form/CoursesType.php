<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CoursesType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('category', null, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Categorías',)))
                ->add('title', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Escribe algo distinto, que llame la atención')))
                ->add('description', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'En 140 caracteres escribe sobre tu curso. Esta descripción estará en la página principal.')))
                ->add('resume', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Este es el momento que todos esperan, en 500 caracteres dino más sobre todo lo que quieras dar.')))
                ->add('photo', FileType::class, array('data_class' => null, 'required' => true, 'attr' => array('class' => 'form-control-file', 'placeholder' => 'File')))
                ->add('video', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => '')))
                ->add('type', null, array('required' => true,'placeholder' => 'Seleccione', 'attr' => array('class' => 'form-control')))
                ->add('place', ChoiceType::class, array('choices' => array($options['locations'][0] => '1', $options['locations'][1] => '2'), 'required' => true, 'attr' => array('class' => 'form-control')))
                ->add('country', CountryType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
                ->add('province', TextType::class)
                ->add('avenue', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
                ->add('address', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
                ->add('knowledge', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control',)))
                ->add('tool', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control',)))
                ->add('minstudent', IntegerType::class, array('required' => true, 'attr' => array('class' => 'form-control',)))
                ->add('maxstudent', IntegerType::class, array('required' => true, 'attr' => array('class' => 'form-control',)))
                ->add('startdate', TextType::class)
                ->add('enddate', TextType::class)
                ->add('hour', TextType::class)
                ->add('days', HiddenType::class)
                ->add('cost', null, array('required' => true, 'placeholder' => 'Seleccione', 'attr' => array('class' => 'form-control',)))
                ->add('currency', EntityType::class, array(
                    'class' => 'AppBundle:Currency',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                                ->orderBy('u.name', 'ASC');
                    },
                    'placeholder' => 'Seleccione',                    
                    'required' => true,
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Courses',
            'locations' => array(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_courses';
    }

}
