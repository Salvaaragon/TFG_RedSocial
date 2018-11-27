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
use SC\DatetimepickerBundle\Form\Type\DatetimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Repository\PlatformRepository;
use AppBundle\Entity\Platform;

class GameGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        date_default_timezone_set('Europe/Madrid');

        $builder
            ->add('game', TextType::class, array(
                "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Juego',
                    'maxlength' => 128),
                "label" => false,
                "required" => "required"))
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
            ->add('datetime', DatetimeType::class, array(
                'data' => $this->getDefaultDateField(),
                'pickerOptions' => array(
                    'format' => 'dd/mm/yyyy hh:ii',
                    'weekStart' => 1,
                    'startDate' => date('d/m/Y H:i', strtotime('+ 1 hour')), // Now date and time
                    'endDate' => date('d/m/Y H:i', strtotime('+ 7 day')), // Now + 1 week
                    'daysOfWeekDisabled' => '',
                    'autoclose' => true,
                    'startView' => 'month',
                    'minView' => 'hour',
                    'maxView' => 'decade',
                    'keyboardNavigation' => true,
                    'language' => 'es',
                    'forceParse' => true,
                    'minuteStep' => 5,
                    'todayHighlight' => true,
                    'pickerReferer ' => 'default', //deprecated
                    'pickerPosition' => 'bottom-right',
                    'viewSelect' => 'hour',
                    'showMeridian' => false,
                    'initialDate' => date('d/m/Y H:i', strtotime('+ 1 hour'))), 
                'attr' => array(
                    'class' => 'datepicker form-control',
                    'readonly' => true, 
                    'placeholder' => 'Fecha y hora',
                    'required' => 'required')))
            ->add('max_participants', IntegerType::class, array(
                "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Participantes',
                    'max' => 12,
                    'min' => 2),
                "label"=>false,"required"=>"required"
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Enviar',
                'attr' => array('class' => 'btn btn-primary',
                                'id' => 'btn_submit_group')
            ))
            ->add('reset', ResetType::class, array(
                'label' => 'Reiniciar formulario',
                'attr' => array('class' => 'btn btn-info',
                                'id' => 'btn_reset_form_group')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => GameGroup::class,
        ));
    }

    private function getDefaultDateField() {

        // Create now date
        $date_now = new \Datetime('now',new \DateTimeZone('Europe/Madrid'));
        $date_now->add(new \DateInterval('PT1H')); // Adding an hour to now date

        $second = $date_now->format('s'); // Get current seconds

        if($second > 0) // Set number seconds to 0
            $date_now->add(new \DateInterval("PT".(60-$second)."S"));

        $minute = $date_now->format('i'); // Get current minutes

        $minute = $minute % 5; // Convert modulo 15

        if($minute != 0) { // Round current minutes
            $diff = 5 - $minute;
            $date_now->add(new \DateInterval("PT".$diff."M"));
        }

        return $date_now;
    }
}