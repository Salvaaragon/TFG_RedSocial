<?php
namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de usuario',
                    'maxlength' => 12),
                "label"=>false,"required"=>"required"))
            ->add('plainPassword', RepeatedType::class, array(
                'required' => 'required',
                'type' => PasswordType::class,
                "attr" => array('class' => 'form-control'),
                'first_options'  => array(
                    "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Contraseña'),
                "label"=>false),
                'second_options' => array(
                    "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Repetir contraseña'),
                "label"=>false)
            ))
            ->add('profileName', TextType::class, array(
                "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de perfil',
                    'maxlength' => 32),
                "label"=>false, "required"=>false))
            ->add('psn_id', TextType::class, array(
                "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Cuenta de PlayStation Network'),
                "label"=>false,"required"=>false))
            ->add('email', EmailType::class, array(
                "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Correo electrónico'),
                "label"=>false,"required"=>"required"))
            ->add('steam_id', TextType::class, array(
                "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Cuenta de Steam'),
                "label"=>false,"required"=>false))
            ->add('xbox_id', TextType::class, array(
                "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Cuenta de Xbox Live'),
                "label"=>false,"required"=>false))
            ->add('submit', SubmitType::class, array(
                'label' => 'Enviar',
                'attr' => array('class' => 'btn btn-primary btn-block')));
            if($options['type'] === 'register')
                $builder->add('reset', ResetType::class, array(
                    'label' => 'Reiniciar formulario',
                    'attr' => array('class' => 'btn btn-info btn-block')
                ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'type' => 'register'
        ));
    }
}