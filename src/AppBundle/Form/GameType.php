<?php
namespace AppBundle\Form;

use AppBundle\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use AppBundle\Entity\Platform;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Repository\PlatformRepository;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Nombre del juego',
                    'rows' => 3,
                    'max_length' => 150),
                "label"=>false,"required"=>"required"))
            ->add('image', FileType::class, array(
                'attr' => array(
                    'id' => 'file_input_image', 
                    'class' => 'file',
                    'data-language' => 'es',
                    'data-show-preview' => 'true',
                    'data-allowed-file-extensions' => '["jpg","gif","png"]',
                    'data-show-upload' => 'true',
                    'data-max-image-width' => '150',
                    'data-max-image-height' => '200',
                    'data-min-image-width' => '150',
                    'data-min-image-height' => '200',
                    'data-show-cancel' => 'false',
                    'required' => 'required'
                    )))
            ->add('platform', EntityType::class, array(
                        'class' => 'AppBundle:Platform',
                        'query_builder' => function (PlatformRepository $pr) {
                            return $pr->createQueryBuilder('p')
                                ->orderBy('p.name', 'ASC');
                        },
                        'choice_label' => 'name',
                        'placeholder' => 'Plataforma',
                        'attr' => array(
                            'class' => 'form-control',
                            'required' => 'required')
                        ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Enviar',
                'attr' => array('class' => 'btn btn-success')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Game::class,
        ));
    }
}