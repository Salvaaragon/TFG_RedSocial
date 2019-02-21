<?php
namespace AppBundle\Form;

use AppBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, array(
                "attr" => array(
                    'class' => 'form-control new_post_text',
                    'placeholder' => '¿Algo nuevo que contar?',
                    'rows' => 3,
                    'max_length' => 150),
                "label"=>false,"required"=>"required"))
            ->add('image', FileType::class, array(
                'attr' => array(
                    'id' => 'file_input_image', 
                    'class' => 'file',
                    'data-language' => 'es',
                    'data-show-preview' => 'false',
                    'data-show-cancel' => 'false',
                    'data-allowed-file-extensions' => '["jpg","gif","png"]',
                    'data-show-upload' => 'false'
                    )))
            ->add('submit', SubmitType::class, array(
                'label' => 'Enviar',
                'attr' => array('class' => 'btn btn-success btn-block')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Post::class,
        ));
    }
}