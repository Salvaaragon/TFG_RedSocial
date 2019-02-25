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

        $user = $options['user'];

        $builder
            ->add('game', ChoiceType::class, array(
                "attr" => array(
                    'class' => 'form-control',
                    'placeholder' => 'Juego',
                    'maxlength' => 128),
                "label" => false,
                "required" => "required",
                "choices" => $this->getGames()))
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
            'user' => null
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

    private function getGames() {
        $games_array = array('Counter-Strike: Global Offensive' => 'Counter-Strike: Global Offensive',
        'PLAYERUNKNOWN\'S BATTLEGROUNDS' => 'PLAYERUNKNOWN\'S BATTLEGROUNDS',
        'Tom Clancy\'s Rainbow Six Siege' => 'Tom Clancy\'s Rainbow Six Siege',
        'Rocket League' => 'Rocket League',
        'Grand Theft Auto V' => 'Grand Theft Auto V',
        'Team Fortress 2' => 'Team Fortress 2',
        'ARK: Survival Evolved' => 'ARK: Survival Evolved',
        'MONSTER HUNTER: WORLD' => 'MONSTER HUNTER: WORLD',
        'Terraria' => 'Terraria',
        'The Elder Scrolls Online' => 'The Elder Scrolls Online',
        'Dead by Daylight' => 'Dead by Daylight',
        'Black Desert Online' => 'Black Desert Online',
        'Paladins' => 'Paladins',
        '7 Days to Die' => '7 Days to Die',
        'Age of Empires II: HD Edition' => 'Age of Empires II: HD Edition',
        'PAYDAY 2' => 'PAYDAY 2',
        'Left 4 Dead 2' => 'Left 4 Dead 2',
        'Assassin\'s Creed Odyssey' => 'Assassin\'s Creed Odyssey',
        'Tom Clancy\'s The Division' => 'Tom Clancy\'s The Division',
        'Far Cry 5' => 'Far Cry 5',
        'For Honor' => 'For Honor',
        'Fifa 19' => 'Fifa 19',
        'Apex' => 'Apex',
        'Dying Light' => 'Dying Light',
        'Tom Clancy\'s Ghost Recon® Wildlands' => 'Tom Clancy\'s Ghost Recon® Wildlands',
        'Fornite' => 'Fornite',
        'Red Dead Redemption 2' => 'Red Dead Redemption 2',
        'Call of Duty: Black Ops 4' => 'Call of Duty: Black Ops 4',
        'Forza Horizon 4' => 'Forza Horizon 4',
        'Battlefield V' => 'Battlefield V',
        'NBA 2K19' => 'NBA 2K19',
        'PES 2019' => 'PES 2019',
        'Destiny 2' => 'Destiny 2',
        'Gear of War 4' => 'Gear of War 4',
        'Overwatch' => 'Overwatch',
        'Minecraft' => 'Minecraft',
        'Forza Motorsport 7' => 'Forza Motorsport 7',
        'Battlefield 1' => 'Battlefield 1',
        'Assassin\'s Creed Origins' => 'Assassin\'s Creed Origins',
        'Star Wars Battlefront II' => 'Star Wars Battlefront II');
        asort($games_array);

        return $games_array;
    }
}