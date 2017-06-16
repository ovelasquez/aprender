<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfileEditType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder->add('name', null, array('label' => 'Nombre', 'required' => true))
                ->add('lastname', null, array('label' => 'Apellido', 'required' => true))
                ->add('photo', FileType::class, array('label' => 'Avatar', 'error_bubbling' => true, 'data_class' => null, 'required' => true, 'attr' => array('class' => 'form-control-file', 'placeholder' => 'File')))
                ->add('website', null, array('label' => 'Sitio Web'))
                ->add('video', null, array('label' => 'Ingresa la url de un video en youtube o vimeo'))
                ->add('subnews', CheckboxType::class, array('label' => 'Subscribe to Newsletter', 'required' => false))
                ->remove('username')->add('username', null, array('label' => 'form.username', 'error_bubbling' => true, 'translation_domain' => 'FOSUserBundle'))
                ->remove('email')->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'form.email', 'error_bubbling' => true, 'translation_domain' => 'FOSUserBundle'))
                ->remove('plainPassword')->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                    'required' => false,
                    'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'form.password', 'error_bubbling' => true),
                    'second_options' => array('label' => 'form.password_confirmation', 'error_bubbling' => true),
                    'invalid_message' => 'fos_user.password.mismatch',
                ))
                ->add('coursecategories', null, array('label' => 'Categorías de Interes', 'required' => false, 'multiple' => true, 'expanded' => true))
                ->add('country', CountryType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
                ->add('province', TextType::class);
    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix() {
        return 'app_user_profile';
    }

    // For Symfony 2.x
    public function getName() {
        return $this->getBlockPrefix();
    }

}
