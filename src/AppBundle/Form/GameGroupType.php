<?php
namespace AppBundle\Form;

use AppBundle\Entity\GameGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class GameGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('game', TextType::class, array(
                "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Juego',
                    'maxlength' => 128),
                "label"=>false,"required"=>"required"))
            ->add('platform', ChoiceType::class, array(
                'choices'  => array(
                    'Steam' => null,
                    'Xbox' => true,
                    'PlayStation' => false,
                )))
            ->add('date', DateType::class)
            ->add('hour', TimeType::class, array(
                'placeholder' => array(
                    'hour' => 'Hora', 'minute' => 'Minuto'
            )))
            ->add('submit', SubmitType::class, array(
                'label' => 'Enviar',
                'attr' => array('class' => 'btn btn-primary')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => GameGroup::class,
        ));
    }
}