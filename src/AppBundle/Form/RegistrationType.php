<?php
/**
 * Created by PhpStorm.
 * User: Rico
 * Date: 27/05/2016
 * Time: 01:07
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', CollectionType::class, array(
                    'type' => 'choice',
                    'options' => array(
                        'label' => false,
                        'choices' => array(
                            'ROLE_CLIENT' => 'Client',
                            'ROLE_MARKET' => 'Market'
                        )
                    )
                )
            )
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}