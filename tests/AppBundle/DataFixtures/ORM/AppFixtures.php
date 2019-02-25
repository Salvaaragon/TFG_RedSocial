<?php 
// src/DataFixtures/ORM/AppFixtures.php
namespace Tests\AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\Platform;
use AppBundle\Entity\Game;
use AppBundle\Entity\Post;
use AppBundle\Entity\PostLike;
use AppBundle\Entity\Following;
use AppBundle\Entity\GameGroup;
use AppBundle\Entity\GameGroupVote;
use AppBundle\Entity\Tournament;
use AppBundle\Entity\TournamentPairing;
use AppBundle\Entity\TournamentRule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->createUsers($manager);
        $this->createPlatforms($manager);
        $this->createGames($manager);
        $this->createPosts($manager);
        $this->createFollowings($manager);
        $this->createGameGroups($manager);
        $this->createTournaments($manager);
        $this->createTournamentsRules($manager);
    }

    private function createUsers(ObjectManager $manager) {
        
        $admin = new User();
        $admin->setUsername('admin_');
        $admin->setEmail('soporte.gamingtogether@gmail.com');
        $admin->setProfileName('Admin');
        $admin->setIsActive(1);
        $admin->setRoles('ROLE_MOD');
        $admin_password = $this->encoder->encodePassword($admin, 'admin_');
        $admin->setPassword($admin_password);

        $manager->persist($admin);

        $user_1 = new User();
        $user_1->setUsername('Salvadoraragon');
        $user_1->setEmail('salva.aragonreyes@gmail.com');
        $user_1->setProfileName('Salva Aragón');
        $user_1->setSteamId('salva_aragon_steam');
        $user_1->setXboxId('salva_aragon_xbox');
        $user_1->setPsnId('salva_aragon_psn');
        $user_1->setIsActive(true);
        $password_1 = $this->encoder->encodePassword($user_1, '8sj20ds4');
        $user_1->setPassword($password_1);

        $manager->persist($user_1);

        $user_2 = new User();
        $user_2->setUsername('miguelangel');
        $user_2->setEmail('miguel.angel@gmail.com');
        $user_2->setProfileName('Miguelito');
        $user_2->setSteamId('miguelangel_steam');
        $user_2->setXboxId('miguelangel_xbox');
        $user_2->setPsnId('miguelangel_psn');
        $user_2->setIsActive(true);
        $password_2 = $this->encoder->encodePassword($user_2, 'jkd7h92h');
        $user_2->setPassword($password_2);

        $manager->persist($user_2);

        $user_3 = new User();
        $user_3->setUsername('ernestoal');
        $user_3->setEmail('ernesto@gmail.com');
        $user_3->setProfileName('Ernesto Grez');
        $user_3->setSteamId('ernestoal_steam');
        $user_3->setXboxId('ernestoal_xbox');
        $user_3->setPsnId('ernestoal_psn');
        $user_3->setIsActive(true);
        $password_3 = $this->encoder->encodePassword($user_3, 'k902jka3');
        $user_3->setPassword($password_3);

        $manager->persist($user_3);

        $user_4 = new User();
        $user_4->setUsername('susana_23');
        $user_4->setEmail('strange_@gmail.com');
        $user_4->setProfileName('Susana Strange');
        $user_4->setSteamId('susana_23_steam');
        $user_4->setXboxId('susana_23_xbox');
        $user_4->setPsnId('susana_23_psn');
        $user_4->setIsActive(true);
        $password_4 = $this->encoder->encodePassword($user_4, '0823ja2d');
        $user_4->setPassword($password_4);

        $manager->persist($user_4);

        $user_5 = new User();
        $user_5->setUsername('darkman');
        $user_5->setEmail('white_link@gmail.com');
        $user_5->setProfileName('darkman');
        $user_5->setSteamId('darkman_steam');
        $user_5->setXboxId('darkman_xbox');
        $user_5->setPsnId('darkman_psn');
        $user_5->setIsActive(true);
        $password_5 = $this->encoder->encodePassword($user_5, 'bv98ds72');
        $user_5->setPassword($password_5);

        $manager->persist($user_5);

        $user_6 = new User();
        $user_6->setUsername('batgirl_');
        $user_6->setEmail('estonoesuncorreo@gmail.com');
        $user_6->setProfileName('It\'s not my name');
        $user_6->setSteamId('batgirl__steam');
        $user_6->setXboxId('batgirl__xbox');
        $user_6->setPsnId('batgirl__psn');
        $user_6->setIsActive(true);
        $password_6 = $this->encoder->encodePassword($user_6, 'as09m23y');
        $user_6->setPassword($password_6);

        $manager->persist($user_6);

        $user_7 = new User();
        $user_7->setUsername('whynot45');
        $user_7->setEmail('nosequeponer@gmail.com');
        $user_7->setProfileName('darkman');
        $user_7->setSteamId('whynot54_steam');
        $user_7->setXboxId('whynot54_xbox');
        $user_7->setPsnId('whynot54_psn');
        $user_7->setIsActive(true);
        $password_7 = $this->encoder->encodePassword($user_7, 'p9qnfv6e');
        $user_7->setPassword($password_7);

        $manager->persist($user_7);

        $user_8 = new User();
        $user_8->setUsername('hugo178');
        $user_8->setEmail('hugo178@gmail.com');
        $user_8->setProfileName('Hugo oguH');
        $user_8->setSteamId('hugo178_steam');
        $user_8->setXboxId('hugo178_xbox');
        $user_8->setPsnId('hugo178_psn');
        $user_8->setIsActive(true);
        $password_8 = $this->encoder->encodePassword($user_8, '0saide63');
        $user_8->setPassword($password_8);

        $manager->persist($user_8);

        $user_9 = new User();
        $user_9->setUsername('teresa_yo');
        $user_9->setEmail('teresa_yo@gmail.com');
        $user_9->setProfileName('Tere');
        $user_9->setSteamId('teresa_yo_steam');
        $user_9->setXboxId('teresa_yo_xbox');
        $user_9->setPsnId('teresa_yo_psn');
        $user_9->setIsActive(true);
        $password_9 = $this->encoder->encodePassword($user_9, 'bv85vcyu');
        $user_9->setPassword($password_9);

        $manager->persist($user_9);

        $user_10 = new User();
        $user_10->setUsername('Maria_bel');
        $user_10->setEmail('Maria_bel@gmail.com');
        $user_10->setProfileName('Maria ');
        $user_10->setSteamId('Maria_bel_steam');
        $user_10->setXboxId('Maria_bel_xbox');
        $user_10->setPsnId('Maria_bel_psn');
        $user_10->setIsActive(true);
        $password_10 = $this->encoder->encodePassword($user_10, '02ods23k');
        $user_10->setPassword($password_10);

        $manager->persist($user_10);

        $user_11 = new User();
        $user_11->setUsername('jenifer_lop');
        $user_11->setEmail('micorreoelectronico@gmail.com');
        $user_11->setProfileName('Jenifer Lop');
        $user_11->setSteamId('jenifer_lop_steam');
        $user_11->setXboxId('jenifer_lop_xbox');
        $user_11->setPsnId('jenifer_lop_psn');
        $user_11->setIsActive(true);
        $password_11 = $this->encoder->encodePassword($user_11, 'ds0dsa98');
        $user_11->setPassword($password_11);

        $manager->persist($user_11);

        $manager->flush();
    }

    private function createPlatforms(ObjectManager $manager) {
        $platform_1 = new Platform();
        $platform_1->setName('Steam');

        $manager->persist($platform_1);
        
        $platform_2 = new Platform();
        $platform_2->setName('Xbox');

        $manager->persist($platform_2);

        $platform_3 = new Platform();
        $platform_3->setName('PlayStation');

        $manager->persist($platform_3);

        $manager->flush();
    }

    private function createGames(ObjectManager $manager) {

        $platform_repository = $manager->getRepository(Platform::class);

        $platform_steam = $platform_repository->findOneBy(array('name'=>'Steam'));
        $platform_playstation = $platform_repository->findOneBy(array('name'=>'PlayStation'));
        $platform_xbox = $platform_repository->findOneBy(array('name'=>'Xbox'));

        $game_1 = new Game();
        $game_1->setName('Assassin\'s Creed Origins');
        $game_1->setPlatform($platform_xbox);

        $manager->persist($game_1);

        $game_2 = new Game();
        $game_2->setName('Battlefield V');
        $game_2->setPlatform($platform_playstation);
        
        $manager->persist($game_2);

        $game_3 = new Game();
        $game_3->setName('Counter Strike: Global Offensive');
        $game_3->setPlatform($platform_steam);
        
        $manager->persist($game_3);

        $game_4 = new Game();
        $game_4->setName('Destiny 2');
        $game_4->setPlatform($platform_xbox);
        
        $manager->persist($game_4);

        $game_5 = new Game();
        $game_5->setName('Far Cry Primal');
        $game_5->setPlatform($platform_playstation);
        
        $manager->persist($game_5);

        $game_6 = new Game();
        $game_6->setName('Garry\'s Mod');
        $game_6->setPlatform($platform_steam);
        
        $manager->persist($game_6);

        $game_7 = new Game();
        $game_7->setName('Halo Wars 2');
        $game_7->setPlatform($platform_xbox);
        
        $manager->persist($game_7);

        $game_8 = new Game();
        $game_8->setName('Monster Hunter: World');
        $game_8->setPlatform($platform_playstation);
        
        $manager->persist($game_8);

        $game_9 = new Game();
        $game_9->setName('Portal 2');
        $game_9->setPlatform($platform_steam);
        
        $manager->persist($game_9);

        $manager->flush();
    }

    private function createPosts(ObjectManager $manager) {

        $user_repository = $manager->getRepository(User::class);

        $user_1 = $user_repository->findOneBy(array('username' => 'teresa_yo'));
        $user_2 = $user_repository->findOneBy(array('username' => 'hugo178'));
        $user_3 = $user_repository->findOneBy(array('username' => 'darkman'));
        $user_4 = $user_repository->findOneBy(array('username' => 'miguelangel'));
        $user_5 = $user_repository->findOneBy(array('username' => 'whynot45'));
        $user_6 = $user_repository->findOneBy(array('username' => 'Salvadoraragon'));
        $user_7 = $user_repository->findOneBy(array('username' => 'ernestoal'));
        $user_8 = $user_repository->findOneBy(array('username' => 'susana_23'));
        $user_9 = $user_repository->findOneBy(array('username' => 'batgirl_'));
        $user_10 = $user_repository->findOneBy(array('username' => 'Maria_bel'));

        $post_1 = new Post();
        $post_1->setText('He jugado al nuevo juego de Respawn');
        $post_1->setDatetime(new \Datetime('17-02-2019 20:30:40'));
        $post_1->setUser($user_1);

        $manager->persist($post_1);

        $post_2 = new Post();
        $post_2->setText('Buscando una guía para completar Mafia III');
        $post_2->setDatetime(new \Datetime('03-01-2019 16:36:34'));
        $post_2->setUser($user_2);

        $manager->persist($post_2);

        $post_3 = new Post();
        $post_3->setText('¿Qué pasará en el próximo E3?');
        $post_3->setDatetime(new \Datetime('29-11-2018 22:56:32'));
        $post_3->setUser($user_3);

        $manager->persist($post_3);

        $post_4 = new Post();
        $post_4->setText('Ojalá en esta web pudiesen también crearse publicaciones para Switch...');
        $post_4->setDatetime(new \Datetime('22-02-2019 06:44:12'));
        $post_4->setUser($user_4);

        $manager->persist($post_4);

        $post_5 = new Post();
        $post_5->setText('Ayer jugué a Fornite por primera vez. A los cinco minutos me conecté a PUBG.');
        $post_5->setDatetime(new \Datetime('08-01-2019 14:17:54'));
        $post_5->setUser($user_5);

        $manager->persist($post_5);

        $post_6 = new Post();
        $post_6->setText('Increíble el nuevo Far Cry. Deseando probarlo ya.');
        $post_6->setDatetime(new \Datetime('12-12-2018 13:49:29'));
        $post_6->setUser($user_1);

        $manager->persist($post_6);

        $post_7 = new Post();
        $post_7->setText('Busco un video de como pasar la última fase de Dark Souls 3');
        $post_7->setDatetime(new \Datetime('20-02-2019 19:56:43'));
        $post_7->setUser($user_2);

        $manager->persist($post_7);

        $post_8 = new Post();
        $post_8->setText('Añado una foto de mi última partida en Call Of Duty BO4. Disfruten.');
        $post_8->setDatetime(new \Datetime('16-12-2018 11:18:51'));
        $post_8->setUser($user_3);

        $manager->persist($post_8);

        $post_9 = new Post();
        $post_9->setText('Hay un bug que impide iniciar sesión en PlayStation Store. Lo están solucionando.');
        $post_9->setDatetime(new \Datetime('09-01-2018 23:40:30'));
        $post_9->setUser($user_4);

        $manager->persist($post_9);

        $post_10 = new Post();
        $post_10->setText('¿Alguien sabe como se llama este juego? Llevo tiempo buscándolo');
        $post_10->setDatetime(new \Datetime('23-10-2018 20:00:34'));
        $post_10->setUser($user_5);

        $manager->persist($post_10);

        $post_11 = new Post();
        $post_11->setText('Participando en el torneo de Counter Strike. Espero ganar.');
        $post_11->setDatetime(new \Datetime('13-01-2019 16:59:32'));
        $post_11->setUser($user_1);

        $manager->persist($post_11);

        $post_12 = new Post();
        $post_12->setText('Hay una gran caida de FPS si juegas la beta de The Division 2 en PlayStation.');
        $post_12->setDatetime(new \Datetime('06-01-2018 15:19:23'));
        $post_12->setUser($user_2);

        $manager->persist($post_12);

        $post_13 = new Post();
        $post_13->setText('Acabo de pillar esta gráfica para mi PC y me llega mañana. Según he leido es la mejor del mercado para videojuegos.');
        $post_13->setDatetime(new \Datetime('18-11-2018 00:23:43'));
        $post_13->setUser($user_3);

        $manager->persist($post_13);

        $post_14 = new Post();
        $post_14->setText('Mi cuenta de Steam tiene ya registrados 400 juegos. He probado solo la cuarta parte.');
        $post_14->setDatetime(new \Datetime('17-02-2019 21:10:00'));
        $post_14->setUser($user_4);

        $manager->persist($post_14);

        $post_15 = new Post();
        $post_15->setText('Para este año espero que salgan al mercado más juegos con juego cruzado.');
        $post_15->setDatetime(new \Datetime('30-01-2019 16:01:04'));
        $post_15->setUser($user_5);

        $manager->persist($post_15);

        $post_16 = new Post();
        $post_16->setText('Mi cuenta de Xbox es pulpin23. Añadidme y jugamos a RDR2');
        $post_16->setDatetime(new \Datetime('13-01-2019 01:50:32'));
        $post_16->setUser($user_1);

        $manager->persist($post_16);

        $post_17 = new Post();
        $post_17->setText('¿Sacarán un nuevo Dead Space algún día?');
        $post_17->setDatetime(new \Datetime('03-02-2019 18:00:32'));
        $post_17->setUser($user_2);

        $manager->persist($post_17);

        $post_18 = new Post();
        $post_18->setText('Voy a crear un grupo para jugar a Gears Of War 4. Buscadlo y uníos.');
        $post_18->setDatetime(new \Datetime('07-02-2019 13:23:55'));
        $post_18->setUser($user_3);

        $manager->persist($post_18);

        $post_19 = new Post();
        $post_19->setText('Algo que he comprobado en esta generación de consolas es que a las cajas de botín aún les queda vida. Una pena.');
        $post_19->setDatetime(new \Datetime('24-02-2019 10:16:23'));
        $post_19->setUser($user_4);

        $manager->persist($post_19);

        $post_20 = new Post();
        $post_20->setText('Este febrero voy a participar en todos los torneos posibles. Quiero aparecer en las clasificaciones de la web.');
        $post_20->setDatetime(new \Datetime('01-02-2019 13:59:32'));
        $post_20->setUser($user_5);

        $manager->persist($post_20);

        $postlike_1 = new Postlike();
        $postlike_1->setUser($user_10);
        $postlike_1->setPost($post_1);
        $postlike_1->setDatetime(new \Datetime('18-02-2019 15:43:10'));

        $manager->persist($postlike_1);

        $postlike_2 = new Postlike();
        $postlike_2->setUser($user_9);
        $postlike_2->setPost($post_1);
        $postlike_2->setDatetime(new \Datetime('19-02-2019 10:31:10'));

        $manager->persist($postlike_2);

        $postlike_3 = new Postlike();
        $postlike_3->setUser($user_8);
        $postlike_3->setPost($post_1);
        $postlike_3->setDatetime(new \Datetime('20-02-2019 06:58:32'));

        $manager->persist($postlike_3);

        $postlike_4 = new Postlike();
        $postlike_4->setUser($user_7);
        $postlike_4->setPost($post_1);
        $postlike_4->setDatetime(new \Datetime('18-02-2019 03:00:05'));

        $manager->persist($postlike_4);

        $postlike_5 = new Postlike();
        $postlike_5->setUser($user_6);
        $postlike_5->setPost($post_1);
        $postlike_5->setDatetime(new \Datetime('19-02-2019 19:32:45'));

        $manager->persist($postlike_5);

        $postlike_6 = new Postlike();
        $postlike_6->setUser($user_5);
        $postlike_6->setPost($post_1);
        $postlike_6->setDatetime(new \Datetime('21-02-2019 18:38:49'));

        $manager->persist($postlike_6);

        $postlike_7 = new Postlike();
        $postlike_7->setUser($user_4);
        $postlike_7->setPost($post_1);
        $postlike_7->setDatetime(new \Datetime('21-02-2019 00:00:32'));

        $manager->persist($postlike_7);

        $postlike_8 = new Postlike();
        $postlike_8->setUser($user_3);
        $postlike_8->setPost($post_1);
        $postlike_8->setDatetime(new \Datetime('23-02-2019 03:03:20'));

        $manager->persist($postlike_8);

        $postlike_9 = new Postlike();
        $postlike_9->setUser($user_7);
        $postlike_9->setPost($post_2);
        $postlike_9->setDatetime(new \Datetime('04-01-2019 07:43:20'));

        $manager->persist($postlike_9);

        $postlike_10 = new Postlike();
        $postlike_10->setUser($user_7);
        $postlike_10->setPost($post_3);
        $postlike_10->setDatetime(new \Datetime('01-12-2018 15:32:00'));

        $manager->persist($postlike_10);

        $postlike_11 = new Postlike();
        $postlike_11->setUser($user_7);
        $postlike_11->setPost($post_4);
        $postlike_11->setDatetime(new \Datetime('25-02-2019 19:02:25'));

        $manager->persist($postlike_11);

        $postlike_12 = new Postlike();
        $postlike_12->setUser($user_7);
        $postlike_12->setPost($post_5);
        $postlike_12->setDatetime(new \Datetime('24-02-2019 10:00:23'));

        $manager->persist($postlike_12);

        $postlike_13 = new Postlike();
        $postlike_13->setUser($user_7);
        $postlike_13->setPost($post_6);
        $postlike_13->setDatetime(new \Datetime('16-12-2018 23:04:39'));

        $manager->persist($postlike_13);

        $postlike_14 = new Postlike();
        $postlike_14->setUser($user_7);
        $postlike_14->setPost($post_7);
        $postlike_14->setDatetime(new \Datetime('21-02-2019 08:59:13'));

        $manager->persist($postlike_14);

        $postlike_15 = new Postlike();
        $postlike_15->setUser($user_7);
        $postlike_15->setPost($post_8);
        $postlike_15->setDatetime(new \Datetime('01-01-2019 09:14:54'));

        $manager->persist($postlike_15);

        $manager->flush();
    }

    private function createFollowings(ObjectManager $manager) {

        $user_repository = $manager->getRepository(User::class);

        $users[0] = $user_repository->findOneBy(array('username' => 'teresa_yo'));
        $users[1] = $user_repository->findOneBy(array('username' => 'hugo178'));
        $users[2] = $user_repository->findOneBy(array('username' => 'darkman'));
        $users[3] = $user_repository->findOneBy(array('username' => 'miguelangel'));
        $users[4] = $user_repository->findOneBy(array('username' => 'whynot45'));
        $users[5] = $user_repository->findOneBy(array('username' => 'Salvadoraragon'));
        $users[6] = $user_repository->findOneBy(array('username' => 'ernestoal'));
        $users[7] = $user_repository->findOneBy(array('username' => 'susana_23'));
        $users[8] = $user_repository->findOneBy(array('username' => 'batgirl_'));
        $users[9] = $user_repository->findOneBy(array('username' => 'Maria_bel'));

        foreach($users as $user_a) {
            foreach($users as $user_b) {
                if($user_a != $user_b) {
                    $following = new Following();
                    $following->setUser($user_a);
                    $following->setUserFollowing($user_b);
                    $manager->persist($following);
                    $manager->flush();
                }
            }
        }
    }

    private function createGameGroups(ObjectManager $manager) {

        $user_repository = $manager->getRepository(User::class);
        $platform_repository = $manager->getRepository(Platform::class);

        $user_1 = $user_repository->findOneBy(array('username' => 'teresa_yo'));
        $user_2 = $user_repository->findOneBy(array('username' => 'hugo178'));
        $user_3 = $user_repository->findOneBy(array('username' => 'darkman'));
        $user_4 = $user_repository->findOneBy(array('username' => 'miguelangel'));
        $user_5 = $user_repository->findOneBy(array('username' => 'whynot45'));
        $user_6 = $user_repository->findOneBy(array('username' => 'Salvadoraragon'));
        $user_7 = $user_repository->findOneBy(array('username' => 'ernestoal'));
        $user_8 = $user_repository->findOneBy(array('username' => 'susana_23'));
        $user_9 = $user_repository->findOneBy(array('username' => 'batgirl_'));
        $user_10 = $user_repository->findOneBy(array('username' => 'Maria_bel'));

        $platform_steam = $platform_repository->findOneBy(array('name'=>'Steam'));
        $platform_playstation = $platform_repository->findOneBy(array('name'=>'PlayStation'));
        $platform_xbox = $platform_repository->findOneBy(array('name'=>'Xbox'));

        $gamegroup_1 = new GameGroup();
        $gamegroup_1->setGame('Counter-Strike: Global Offensive');
        $gamegroup_1->setPlatform($platform_steam);
        $gamegroup_1->setUser($user_1);
        $gamegroup_1->setDatetime(new \Datetime('18-11-2018 20:45'));
        $gamegroup_1->setMaxParticipants(3);
        $gamegroup_1->setIsActive(false);
        $gamegroup_1->addParticipant($user_2);
        $gamegroup_1->addParticipant($user_3);

        $manager->persist($gamegroup_1);
        $this->createGameGroupsVotes($manager,$gamegroup_1,4);

        $gamegroup_2 = new GameGroup();
        $gamegroup_2->setGame('PLAYERUNKNOWN\'S BATTLEGROUNDS');
        $gamegroup_2->setPlatform($platform_xbox);
        $gamegroup_2->setUser($user_2);
        $gamegroup_2->setDatetime(new \Datetime('20-11-2018 16:00'));
        $gamegroup_2->setMaxParticipants(2);
        $gamegroup_2->setIsActive(false);
        $gamegroup_2->addParticipant($user_8);
        $gamegroup_2->addParticipant($user_9);

        $manager->persist($gamegroup_2);
        $this->createGameGroupsVotes($manager,$gamegroup_2,4);

        $gamegroup_3 = new GameGroup();
        $gamegroup_3->setGame('Tom Clancy\'s Rainbow Six Siege');
        $gamegroup_3->setPlatform($platform_playstation);
        $gamegroup_3->setUser($user_3);
        $gamegroup_3->setDatetime(new \Datetime('24-11-2018 10:30'));
        $gamegroup_3->setMaxParticipants(3);
        $gamegroup_3->setIsActive(false);
        $gamegroup_3->addParticipant($user_9);
        $gamegroup_3->addParticipant($user_10);
        $gamegroup_3->addParticipant($user_1);

        $manager->persist($gamegroup_3);
        $this->createGameGroupsVotes($manager,$gamegroup_3,3);

        $gamegroup_4 = new GameGroup();
        $gamegroup_4->setGame('Rocket League');
        $gamegroup_4->setPlatform($platform_steam);
        $gamegroup_4->setUser($user_4);
        $gamegroup_4->setDatetime(new \Datetime('29-11-2018 19:15'));
        $gamegroup_4->setMaxParticipants(2);
        $gamegroup_4->setIsActive(false);
        $gamegroup_4->addParticipant($user_2);

        $manager->persist($gamegroup_4);
        $this->createGameGroupsVotes($manager,$gamegroup_4,1);

        $gamegroup_5 = new GameGroup();
        $gamegroup_5->setGame('Grand Theft Auto V');
        $gamegroup_5->setPlatform($platform_playstation);
        $gamegroup_5->setUser($user_5);
        $gamegroup_5->setDatetime(new \Datetime('02-12-2018 00:00'));
        $gamegroup_5->setMaxParticipants(1);
        $gamegroup_5->setIsActive(false);

        $manager->persist($gamegroup_5);

        $gamegroup_6 = new GameGroup();
        $gamegroup_6->setGame('Team Fortress 2');
        $gamegroup_6->setPlatform($platform_steam);
        $gamegroup_6->setUser($user_6);
        $gamegroup_6->setDatetime(new \Datetime('10-11-2018 20:00'));
        $gamegroup_6->setMaxParticipants(3);
        $gamegroup_6->setIsActive(false);
        $gamegroup_6->addParticipant($user_3);
        $gamegroup_6->addParticipant($user_4);
        $gamegroup_6->addParticipant($user_5);

        $manager->persist($gamegroup_6);
        $this->createGameGroupsVotes($manager,$gamegroup_6,5);

        $gamegroup_7 = new GameGroup();
        $gamegroup_7->setGame('ARK: Survival Evolved');
        $gamegroup_7->setPlatform($platform_xbox);
        $gamegroup_7->setUser($user_7);
        $gamegroup_7->setDatetime(new \Datetime('12-11-2018 09:45'));
        $gamegroup_7->setMaxParticipants(2);
        $gamegroup_7->setIsActive(false);
        $gamegroup_7->addParticipant($user_6);

        $manager->persist($gamegroup_7);
        $this->createGameGroupsVotes($manager,$gamegroup_7,2);

        $gamegroup_8 = new GameGroup();
        $gamegroup_8->setGame('MONSTER HUNTER: WORLD');
        $gamegroup_8->setPlatform($platform_playstation);
        $gamegroup_8->setUser($user_8);
        $gamegroup_8->setDatetime(new \Datetime('15-11-2018 13:30'));
        $gamegroup_8->setMaxParticipants(2);
        $gamegroup_8->setIsActive(false);
        $gamegroup_8->addParticipant($user_9);
        $gamegroup_8->addParticipant($user_10);

        $manager->persist($gamegroup_8);
        $this->createGameGroupsVotes($manager,$gamegroup_8,4);

        $gamegroup_9 = new GameGroup();
        $gamegroup_9->setGame('Terraria');
        $gamegroup_9->setPlatform($platform_steam);
        $gamegroup_9->setUser($user_9);
        $gamegroup_9->setDatetime(new \Datetime('17-11-2018 14:00'));
        $gamegroup_9->setMaxParticipants(2);
        $gamegroup_9->setIsActive(false);
        $gamegroup_9->addParticipant($user_10);
        $gamegroup_9->addParticipant($user_1);

        $manager->persist($gamegroup_9);
        $this->createGameGroupsVotes($manager,$gamegroup_9,5);

        $gamegroup_10 = new GameGroup();
        $gamegroup_10->setGame('The Elder Scrolls Online');
        $gamegroup_10->setPlatform($platform_xbox);
        $gamegroup_10->setUser($user_10);
        $gamegroup_10->setDatetime(new \Datetime('20-11-2018 17:45'));
        $gamegroup_10->setMaxParticipants(2);
        $gamegroup_10->setIsActive(false);
        $gamegroup_10->addParticipant($user_2);

        $manager->persist($gamegroup_10);
        $this->createGameGroupsVotes($manager,$gamegroup_10,2);

        $gamegroup_11 = new GameGroup();
        $gamegroup_11->setGame('Dead by Daylight');
        $gamegroup_11->setPlatform($platform_playstation);
        $gamegroup_11->setUser($user_1);
        $gamegroup_11->setDatetime(new \Datetime('21-11-2018 18:00'));
        $gamegroup_11->setMaxParticipants(4);
        $gamegroup_11->setIsActive(false);
        $gamegroup_11->addParticipant($user_3);
        $gamegroup_11->addParticipant($user_4);
        $gamegroup_11->addParticipant($user_5);

        $manager->persist($gamegroup_11);
        $this->createGameGroupsVotes($manager,$gamegroup_11,3);

        $gamegroup_12 = new GameGroup();
        $gamegroup_12->setGame('Black Desert Online');
        $gamegroup_12->setPlatform($platform_steam);
        $gamegroup_12->setUser($user_2);
        $gamegroup_12->setDatetime(new \Datetime('21-11-2018 19:45'));
        $gamegroup_12->setMaxParticipants(3);
        $gamegroup_12->setIsActive(false);
        $gamegroup_12->addParticipant($user_6);
        $gamegroup_12->addParticipant($user_7);

        $manager->persist($gamegroup_12);
        $this->createGameGroupsVotes($manager,$gamegroup_12,4);

        $gamegroup_13 = new GameGroup();
        $gamegroup_13->setGame('Paladins');
        $gamegroup_13->setPlatform($platform_xbox);
        $gamegroup_13->setUser($user_3);
        $gamegroup_13->setDatetime(new \Datetime('03-12-2018 22:30'));
        $gamegroup_13->setMaxParticipants(2);
        $gamegroup_13->setIsActive(false);
        $gamegroup_13->addParticipant($user_8);
        $gamegroup_13->addParticipant($user_9);

        $manager->persist($gamegroup_13);
        $this->createGameGroupsVotes($manager,$gamegroup_13,5);

        $gamegroup_14 = new GameGroup();
        $gamegroup_14->setGame('7 Days to Die');
        $gamegroup_14->setPlatform($platform_playstation);
        $gamegroup_14->setUser($user_4);
        $gamegroup_14->setDatetime(new \Datetime('08-12-2018 19:00'));
        $gamegroup_14->setMaxParticipants(1);
        $gamegroup_14->setIsActive(false);
        $gamegroup_14->addParticipant($user_2);

        $manager->persist($gamegroup_14);
        $this->createGameGroupsVotes($manager,$gamegroup_14,1);

        $gamegroup_15 = new GameGroup();
        $gamegroup_15->setGame('Age of Empires II: HD Edition');
        $gamegroup_15->setPlatform($platform_steam);
        $gamegroup_15->setUser($user_5);
        $gamegroup_15->setDatetime(new \Datetime('15-12-2018 15:30'));
        $gamegroup_15->setMaxParticipants(3);
        $gamegroup_15->setIsActive(false);
        $gamegroup_15->addParticipant($user_3);
        $gamegroup_15->addParticipant($user_4);
        $gamegroup_15->addParticipant($user_6);

        $manager->persist($gamegroup_15);
        $this->createGameGroupsVotes($manager,$gamegroup_15,2);

        $gamegroup_16 = new GameGroup();
        $gamegroup_16->setGame('PAYDAY 2');
        $gamegroup_16->setPlatform($platform_xbox);
        $gamegroup_16->setUser($user_6);
        $gamegroup_16->setDatetime(new \Datetime('21-12-2018 16:45'));
        $gamegroup_16->setMaxParticipants(2);
        $gamegroup_16->setIsActive(false);

        $manager->persist($gamegroup_16);

        $gamegroup_17 = new GameGroup();
        $gamegroup_17->setGame('Left 4 Dead 2');
        $gamegroup_17->setPlatform($platform_steam);
        $gamegroup_17->setUser($user_7);
        $gamegroup_17->setDatetime(new \Datetime('24-12-2018 19:45'));
        $gamegroup_17->setMaxParticipants(3);
        $gamegroup_17->setIsActive(false);
        $gamegroup_17->addParticipant($user_5);
        $gamegroup_17->addParticipant($user_8);
        $gamegroup_17->addParticipant($user_9);

        $manager->persist($gamegroup_17);
        $this->createGameGroupsVotes($manager,$gamegroup_17,3);

        $gamegroup_18 = new GameGroup();
        $gamegroup_18->setGame('Assassin\'s Creed Odyssey');
        $gamegroup_18->setPlatform($platform_playstation);
        $gamegroup_18->setUser($user_8);
        $gamegroup_18->setDatetime(new \Datetime('29-12-2018 21:30'));
        $gamegroup_18->setMaxParticipants(2);
        $gamegroup_18->setIsActive(false);
        $gamegroup_18->addParticipant($user_7);
        $gamegroup_18->addParticipant($user_10);

        $manager->persist($gamegroup_18);
        $this->createGameGroupsVotes($manager,$gamegroup_18,4);

        $gamegroup_19 = new GameGroup();
        $gamegroup_19->setGame('Tom Clancy\'s The Division');
        $gamegroup_19->setPlatform($platform_xbox);
        $gamegroup_19->setUser($user_9);
        $gamegroup_19->setDatetime(new \Datetime('02-01-2019 20:45'));
        $gamegroup_19->setMaxParticipants(2);
        $gamegroup_19->setIsActive(false);
        $gamegroup_19->addParticipant($user_1);
        $gamegroup_19->addParticipant($user_2);

        $manager->persist($gamegroup_19);
        $this->createGameGroupsVotes($manager,$gamegroup_19,4);

        $gamegroup_20 = new GameGroup();
        $gamegroup_20->setGame('Far Cry 5');
        $gamegroup_20->setPlatform($platform_playstation);
        $gamegroup_20->setUser($user_10);
        $gamegroup_20->setDatetime(new \Datetime('10-01-2019 14:30'));
        $gamegroup_20->setMaxParticipants(3);
        $gamegroup_20->setIsActive(false);
        $gamegroup_20->addParticipant($user_3);
        $gamegroup_20->addParticipant($user_4);
        $gamegroup_20->addParticipant($user_5);

        $manager->persist($gamegroup_20);
        $this->createGameGroupsVotes($manager,$gamegroup_20,5);

        $gamegroup_21 = new GameGroup();
        $gamegroup_21->setGame('For Honor');
        $gamegroup_21->setPlatform($platform_xbox);
        $gamegroup_21->setUser($user_1);
        $gamegroup_21->setDatetime(new \Datetime('15-01-2019 10:00'));
        $gamegroup_21->setMaxParticipants(2);
        $gamegroup_21->setIsActive(false);
        $gamegroup_21->addParticipant($user_6);
        $gamegroup_21->addParticipant($user_7);

        $manager->persist($gamegroup_21);
        $this->createGameGroupsVotes($manager,$gamegroup_21,2);

        $gamegroup_22 = new GameGroup();
        $gamegroup_22->setGame('Fifa 19');
        $gamegroup_22->setPlatform($platform_playstation);
        $gamegroup_22->setUser($user_2);
        $gamegroup_22->setDatetime(new \Datetime('16-01-2019 19:00'));
        $gamegroup_22->setMaxParticipants(4);
        $gamegroup_22->setIsActive(false);
        $gamegroup_22->addParticipant($user_8);
        $gamegroup_22->addParticipant($user_9);
        $gamegroup_22->addParticipant($user_10);

        $manager->persist($gamegroup_22);
        $this->createGameGroupsVotes($manager,$gamegroup_22,3);

        $gamegroup_23 = new GameGroup();
        $gamegroup_23->setGame('Dying Light');
        $gamegroup_23->setPlatform($platform_steam);
        $gamegroup_23->setUser($user_3);
        $gamegroup_23->setDatetime(new \Datetime('14-01-2019 23:15'));
        $gamegroup_23->setMaxParticipants(2);
        $gamegroup_23->setIsActive(false);
        $gamegroup_23->addParticipant($user_1);
        $gamegroup_23->addParticipant($user_2);

        $manager->persist($gamegroup_23);
        $this->createGameGroupsVotes($manager,$gamegroup_23,5);

        $gamegroup_24 = new GameGroup();
        $gamegroup_24->setGame('Tom Clancy\'s Ghost Recon® Wildlands');
        $gamegroup_24->setPlatform($platform_xbox);
        $gamegroup_24->setUser($user_4);
        $gamegroup_24->setDatetime(new \Datetime('20-01-2019 08:00'));
        $gamegroup_24->setMaxParticipants(3);
        $gamegroup_24->setIsActive(false);
        $gamegroup_24->addParticipant($user_3);
        $gamegroup_24->addParticipant($user_5);
        $gamegroup_24->addParticipant($user_6);

        $manager->persist($gamegroup_24);
        $this->createGameGroupsVotes($manager,$gamegroup_24,4);

        $gamegroup_25 = new GameGroup();
        $gamegroup_25->setGame('Fornite');
        $gamegroup_25->setPlatform($platform_playstation);
        $gamegroup_25->setUser($user_5);
        $gamegroup_25->setDatetime(new \Datetime('25-01-2019 00:00'));
        $gamegroup_25->setMaxParticipants(2);
        $gamegroup_25->setIsActive(false);
        $gamegroup_25->addParticipant($user_4);
        $gamegroup_25->addParticipant($user_7);

        $manager->persist($gamegroup_25);
        $this->createGameGroupsVotes($manager,$gamegroup_25,1);

        $gamegroup_26 = new GameGroup();
        $gamegroup_26->setGame('Red Dead Redemption 2');
        $gamegroup_26->setPlatform($platform_xbox);
        $gamegroup_26->setUser($user_6);
        $gamegroup_26->setDatetime(new \Datetime('03-02-2019 15:00'));
        $gamegroup_26->setMaxParticipants(2);
        $gamegroup_26->setIsActive(false);
        $gamegroup_26->addParticipant($user_8);
        $gamegroup_26->addParticipant($user_9);

        $manager->persist($gamegroup_26);
        $this->createGameGroupsVotes($manager,$gamegroup_26,2);

        $gamegroup_27 = new GameGroup();
        $gamegroup_27->setGame('Call of Duty: Black Ops 4');
        $gamegroup_27->setPlatform($platform_playstation);
        $gamegroup_27->setUser($user_7);
        $gamegroup_27->setDatetime(new \Datetime('24-02-2019 18:30'));
        $gamegroup_27->setMaxParticipants(5);
        $gamegroup_27->setIsActive(true);
        $gamegroup_27->addParticipant($user_10);

        $manager->persist($gamegroup_27);
        $this->createGameGroupsVotes($manager,$gamegroup_27,5);

        $gamegroup_28 = new GameGroup();
        $gamegroup_28->setGame('Forza Horizon 4');
        $gamegroup_28->setPlatform($platform_xbox);
        $gamegroup_28->setUser($user_8);
        $gamegroup_28->setDatetime(new \Datetime('24-02-2019 19:00'));
        $gamegroup_28->setMaxParticipants(2);
        $gamegroup_28->setIsActive(true);
        $gamegroup_28->addParticipant($user_1);
        $gamegroup_28->addParticipant($user_2);

        $manager->persist($gamegroup_28);
        $this->createGameGroupsVotes($manager,$gamegroup_28,4);

        $gamegroup_29 = new GameGroup();
        $gamegroup_29->setGame('Destiny 2');
        $gamegroup_29->setPlatform($platform_playstation);
        $gamegroup_29->setUser($user_9);
        $gamegroup_29->setDatetime(new \Datetime('24-02-2019 20:45'));
        $gamegroup_29->setMaxParticipants(3);
        $gamegroup_29->setIsActive(true);
        $gamegroup_29->addParticipant($user_3);

        $manager->persist($gamegroup_29);
        $this->createGameGroupsVotes($manager,$gamegroup_29,3);

        $gamegroup_30 = new GameGroup();
        $gamegroup_30->setGame('Apex');
        $gamegroup_30->setPlatform($platform_playstation);
        $gamegroup_30->setUser($user_10);
        $gamegroup_30->setDatetime(new \Datetime('25-02-2019 09:00'));
        $gamegroup_30->setMaxParticipants(2);
        $gamegroup_30->setIsActive(true);
        $gamegroup_30->addParticipant($user_4);

        $manager->persist($gamegroup_30);

        $manager->flush();
    }

    private function createGameGroupsVotes(ObjectManager $manager, GameGroup $g, int $vote) {

        $participants = $g->getParticipants();
        $participants->add($g->getUser());

        foreach($participants as $part_a) {
            foreach($participants as $part_b) {
                if($part_a != $part_b) {
                    $gamegroup_vote = new GameGroupVote();
                    $gamegroup_vote->setUser($part_a);
                    $gamegroup_vote->setUserVoted($part_b);
                    $gamegroup_vote->setGameGroup($g);

                    $datetime = new \Datetime($g->getDatetime()->format('d-m-Y H:i'));
                    $datetime->add(new \DateInterval('PT1H'));
                    $gamegroup_vote->setDatetime($datetime);
                    $gamegroup_vote->setVote($vote);

                    $manager->persist($gamegroup_vote);
                    $manager->flush();
                }
            }
        } 
    }

    private function createTournaments(ObjectManager $manager) {

        $platform_repository = $manager->getRepository(Platform::class);
        $game_repository = $manager->getRepository(Game::class);
        $user_repository = $manager->getRepository(User::class);

        $user_1 = $user_repository->findOneBy(array('username' => 'teresa_yo'));
        $user_2 = $user_repository->findOneBy(array('username' => 'hugo178'));
        $user_3 = $user_repository->findOneBy(array('username' => 'darkman'));
        $user_4 = $user_repository->findOneBy(array('username' => 'miguelangel'));
        $user_5 = $user_repository->findOneBy(array('username' => 'whynot45'));
        $user_6 = $user_repository->findOneBy(array('username' => 'Salvadoraragon'));
        $user_7 = $user_repository->findOneBy(array('username' => 'ernestoal'));
        $user_8 = $user_repository->findOneBy(array('username' => 'susana_23'));
        $user_9 = $user_repository->findOneBy(array('username' => 'batgirl_'));
        $user_10 = $user_repository->findOneBy(array('username' => 'Maria_bel'));

        $platform_steam = $platform_repository->findOneBy(array('name'=>'Steam'));
        $platform_playstation = $platform_repository->findOneBy(array('name'=>'PlayStation'));
        $platform_xbox = $platform_repository->findOneBy(array('name'=>'Xbox'));

        $game_1 = $game_repository->findOneBy(
            array(
                'name' => 'Assassin\'s Creed Origins',
                'platform' => $platform_xbox));
        $game_2 = $game_repository->findOneBy(
            array(
                'name' => 'Battlefield V',
                'platform' => $platform_playstation));
        $game_3 = $game_repository->findOneBy(
            array(
                'name' => 'Counter Strike: Global Offensive',
                'platform' => $platform_steam));
        $game_4 = $game_repository->findOneBy(
            array(
                'name' => 'Destiny 2',
                'platform' => $platform_xbox));
        $game_5 = $game_repository->findOneBy(
            array(
                'name' => 'Far Cry Primal',
                'platform' => $platform_playstation));
        $game_6 = $game_repository->findOneBy(
            array(
                'name' => 'Garry\'s Mod',
                'platform' => $platform_steam));
        $game_7 = $game_repository->findOneBy(
            array(
                'name' => 'Halo Wars 2',
                'platform' => $platform_xbox));
        $game_8 = $game_repository->findOneBy(
            array(
                'name' => 'Monster Hunter: World',
                'platform' => $platform_playstation));
        $game_9 = $game_repository->findOneBy(
            array(
                'name' => 'Portal 2',
                'platform' => $platform_steam));

        $tournament_1 = new Tournament();
        $tournament_1->setName('Torneo jueves 10 de enero');
        $tournament_1->setGame($game_2);
        $tournament_1->setDatetime(new \Datetime('10-01-2019 20:30'));
        $tournament_1->setParticipantsRequired(8);
        $tournament_1->setType('eliminatoria');
        $tournament_1->setCurrentRound(3);
        $tournament_1->setIsActive(0);
        $tournament_1->addParticipant($user_1);
        $tournament_1->addParticipant($user_2);
        $tournament_1->addParticipant($user_3);
        $tournament_1->addParticipant($user_4);
        $tournament_1->addParticipant($user_5);
        $tournament_1->addParticipant($user_6);
        $tournament_1->addParticipant($user_7);
        $tournament_1->addParticipant($user_8);
        $tournament_1->setWinner($user_7);

        $manager->persist($tournament_1);

        $tournament_2 = new Tournament();
        $tournament_2->setName('Torneo domingo 13 de enero');
        $tournament_2->setGame($game_3);
        $tournament_2->setDatetime(new \Datetime('13-01-2019 18:00'));
        $tournament_2->setParticipantsRequired(4);
        $tournament_2->setType('eliminatoria');
        $tournament_2->setCurrentRound(2);
        $tournament_2->setIsActive(0);
        $tournament_2->addParticipant($user_9);
        $tournament_2->addParticipant($user_10);
        $tournament_2->addParticipant($user_1);
        $tournament_2->addParticipant($user_2);
        $tournament_2->setWinner($user_1);

        $manager->persist($tournament_2);

        $tournament_3 = new Tournament();
        $tournament_3->setName('Torneo miércoles 16 de enero');
        $tournament_3->setGame($game_7);
        $tournament_3->setDatetime(new \Datetime('16-01-2019 16:30'));
        $tournament_3->setParticipantsRequired(6);
        $tournament_3->setType('eliminatoria');
        $tournament_3->setCurrentRound(3);
        $tournament_3->setIsActive(0);
        $tournament_3->addParticipant($user_3);
        $tournament_3->addParticipant($user_4);
        $tournament_3->addParticipant($user_5);
        $tournament_3->addParticipant($user_6);
        $tournament_3->addParticipant($user_7);
        $tournament_3->addParticipant($user_8);
        $tournament_3->setWinner($user_5);

        $manager->persist($tournament_3);

        $tournament_4 = new Tournament();
        $tournament_4->setName('Torneo jueves 17 de enero');
        $tournament_4->setGame($game_6);
        $tournament_4->setDatetime(new \Datetime('17-01-2019 10:00'));
        $tournament_4->setParticipantsRequired(8);
        $tournament_4->setType('eliminatoria');
        $tournament_4->setCurrentRound(3);
        $tournament_4->setIsActive(0);
        $tournament_4->addParticipant($user_9);
        $tournament_4->addParticipant($user_10);
        $tournament_4->addParticipant($user_1);
        $tournament_4->addParticipant($user_2);
        $tournament_4->addParticipant($user_3);
        $tournament_4->addParticipant($user_4);
        $tournament_4->addParticipant($user_5);
        $tournament_4->addParticipant($user_6);
        $tournament_4->setWinner($user_5);

        $manager->persist($tournament_4);

        $tournament_5 = new Tournament();
        $tournament_5->setName('Torneo lunes 21 de enero');
        $tournament_5->setGame($game_3);
        $tournament_5->setDatetime(new \Datetime('21-01-2019 11:00'));
        $tournament_5->setParticipantsRequired(7);
        $tournament_5->setType('eliminatoria');
        $tournament_5->setCurrentRound(3);
        $tournament_5->setIsActive(0);
        $tournament_5->addParticipant($user_7);
        $tournament_5->addParticipant($user_8);
        $tournament_5->addParticipant($user_9);
        $tournament_5->addParticipant($user_10);
        $tournament_5->addParticipant($user_1);
        $tournament_5->addParticipant($user_2);
        $tournament_5->addParticipant($user_3);
        $tournament_5->setWinner($user_7);

        $manager->persist($tournament_5);

        $tournament_6 = new Tournament();
        $tournament_6->setName('Torneo miércoles 23 de enero');
        $tournament_6->setGame($game_4);
        $tournament_6->setDatetime(new \Datetime('23-01-2019 12:30'));
        $tournament_6->setParticipantsRequired(4);
        $tournament_6->setType('eliminatoria');
        $tournament_6->setCurrentRound(3);
        $tournament_6->setIsActive(0);
        $tournament_6->addParticipant($user_4);
        $tournament_6->addParticipant($user_5);
        $tournament_6->addParticipant($user_6);
        $tournament_6->addParticipant($user_7);
        $tournament_6->setWinner($user_5);

        $manager->persist($tournament_6);

        $tournament_7 = new Tournament();
        $tournament_7->setName('Torneo sábado 26 de enero');
        $tournament_7->setGame($game_5);
        $tournament_7->setDatetime(new \Datetime('26-01-2019 22:30'));
        $tournament_7->setParticipantsRequired(4);
        $tournament_7->setType('eliminatoria');
        $tournament_7->setCurrentRound(2);
        $tournament_7->setIsActive(0);
        $tournament_7->addParticipant($user_8);
        $tournament_7->addParticipant($user_9);
        $tournament_7->addParticipant($user_10);
        $tournament_7->addParticipant($user_1);
        $tournament_7->setWinner($user_8);

        $manager->persist($tournament_7);

        $tournament_8 = new Tournament();
        $tournament_8->setName('Torneo domingo 27 de enero');
        $tournament_8->setGame($game_2);
        $tournament_8->setDatetime(new \Datetime('27-01-2019 18:00'));
        $tournament_8->setParticipantsRequired(5);
        $tournament_8->setType('eliminatoria');
        $tournament_8->setCurrentRound(3);
        $tournament_8->setIsActive(0);
        $tournament_8->addParticipant($user_2);
        $tournament_8->addParticipant($user_3);
        $tournament_8->addParticipant($user_4);
        $tournament_8->addParticipant($user_5);
        $tournament_8->addParticipant($user_6);
        $tournament_8->setWinner($user_4);

        $manager->persist($tournament_8);

        $tournament_9 = new Tournament();
        $tournament_9->setName('Torneo martes 29 de enero');
        $tournament_9->setGame($game_2);
        $tournament_9->setDatetime(new \Datetime('29-01-2019 21:30'));
        $tournament_9->setParticipantsRequired(8);
        $tournament_9->setType('eliminatoria');
        $tournament_9->setCurrentRound(3);
        $tournament_9->setIsActive(0);
        $tournament_9->addParticipant($user_7);
        $tournament_9->addParticipant($user_8);
        $tournament_9->addParticipant($user_9);
        $tournament_9->addParticipant($user_10);
        $tournament_9->addParticipant($user_1);
        $tournament_9->addParticipant($user_2);
        $tournament_9->addParticipant($user_3);
        $tournament_9->addParticipant($user_4);
        $tournament_9->setWinner($user_3);

        $manager->persist($tournament_9);

        $tournament_10 = new Tournament();
        $tournament_10->setName('Torneo domingo 3 de febrero');
        $tournament_10->setGame($game_3);
        $tournament_10->setDatetime(new \Datetime('03-02-2019 15:00'));
        $tournament_10->setParticipantsRequired(9);
        $tournament_10->setType('eliminatoria');
        $tournament_10->setCurrentRound(4);
        $tournament_10->setIsActive(0);
        $tournament_10->addParticipant($user_5);
        $tournament_10->addParticipant($user_6);
        $tournament_10->addParticipant($user_7);
        $tournament_10->addParticipant($user_8);
        $tournament_10->addParticipant($user_9);
        $tournament_10->addParticipant($user_10);
        $tournament_10->addParticipant($user_1);
        $tournament_10->addParticipant($user_2);
        $tournament_10->addParticipant($user_3);
        $tournament_10->setWinner($user_2);

        $manager->persist($tournament_10);

        $tournament_11 = new Tournament();
        $tournament_11->setName('Torneo domingo 10 de febrero');
        $tournament_11->setGame($game_9);
        $tournament_11->setDatetime(new \Datetime('10-02-2019 14:30'));
        $tournament_11->setParticipantsRequired(3);
        $tournament_11->setType('eliminatoria');
        $tournament_11->setCurrentRound(2);
        $tournament_11->setIsActive(0);
        $tournament_11->addParticipant($user_4);
        $tournament_11->addParticipant($user_5);
        $tournament_11->addParticipant($user_6);
        $tournament_11->setWinner($user_4);

        $manager->persist($tournament_11);

        $tournament_12 = new Tournament();
        $tournament_12->setName('Torneo lunes 25 de enero');
        $tournament_12->setGame($game_1);
        $tournament_12->setDatetime(new \Datetime('25-01-2019 10:00'));
        $tournament_12->setParticipantsRequired(4);
        $tournament_12->setType('eliminatoria');
        $tournament_12->setCurrentRound(2);
        $tournament_12->setIsActive(1);
        $tournament_12->addParticipant($user_8);
        $tournament_12->addParticipant($user_9);
        $tournament_12->addParticipant($user_10);
        $tournament_12->addParticipant($user_1);

        $manager->persist($tournament_12);

        $tournament_13 = new Tournament();
        $tournament_13->setName('Torneo lunes 25 de enero');
        $tournament_13->setGame($game_8);
        $tournament_13->setDatetime(new \Datetime('25-01-2019 11:30'));
        $tournament_13->setParticipantsRequired(3);
        $tournament_13->setType('eliminatoria');
        $tournament_13->setCurrentRound(2);
        $tournament_13->setIsActive(1);
        $tournament_13->addParticipant($user_2);
        $tournament_13->addParticipant($user_3);
        $tournament_13->addParticipant($user_4);

        $manager->persist($tournament_13);

        $tournament_14 = new Tournament();
        $tournament_14->setName('Torneo lunes 25 de enero');
        $tournament_14->setGame($game_4);
        $tournament_14->setDatetime(new \Datetime('25-01-2019 13:00'));
        $tournament_14->setParticipantsRequired(4);
        $tournament_14->setType('eliminatoria');
        $tournament_14->setCurrentRound(2);
        $tournament_14->setIsActive(1);
        $tournament_14->addParticipant($user_5);
        $tournament_14->addParticipant($user_6);
        $tournament_14->addParticipant($user_7);
        $tournament_14->addParticipant($user_8);

        $manager->persist($tournament_14);

        $tournament_15 = new Tournament();
        $tournament_15->setName('Torneo lunes 25 de enero');
        $tournament_15->setGame($game_5);
        $tournament_15->setDatetime(new \Datetime('25-01-2019 14:00'));
        $tournament_15->setParticipantsRequired(4);
        $tournament_15->setType('eliminatoria');
        $tournament_15->setCurrentRound(2);
        $tournament_15->setIsActive(1);
        $tournament_15->addParticipant($user_9);
        $tournament_15->addParticipant($user_10);
        $tournament_15->addParticipant($user_1);
        $tournament_15->addParticipant($user_2);

        $manager->persist($tournament_15);

        $manager->flush();

        // Creamos todos los emparejamientos con resultados y demás
        // Emparejamientos torneo 1
        $pairing_1_t1 = new TournamentPairing();
        $pairing_1_t1->setPlayerOne($user_1);
        $pairing_1_t1->setPlayerTwo($user_2);
        $pairing_1_t1->setResultPlayerOne($user_1->getUsername());
        $pairing_1_t1->setResultPlayerTwo($user_1->getUsername());
        $pairing_1_t1->setWinner($user_1);
        $pairing_1_t1->setRound(1);
        $pairing_1_t1->setTournament($tournament_1);

        $manager->persist($pairing_1_t1);

        $pairing_2_t1 = new TournamentPairing();
        $pairing_2_t1->setPlayerOne($user_3);
        $pairing_2_t1->setPlayerTwo($user_4);
        $pairing_2_t1->setResultPlayerOne($user_3->getUsername());
        $pairing_2_t1->setResultPlayerTwo($user_3->getUsername());
        $pairing_2_t1->setWinner($user_3);
        $pairing_2_t1->setRound(1);
        $pairing_2_t1->setTournament($tournament_1);

        $manager->persist($pairing_2_t1);

        $pairing_3_t1 = new TournamentPairing();
        $pairing_3_t1->setPlayerOne($user_5);
        $pairing_3_t1->setPlayerTwo($user_6);
        $pairing_3_t1->setResultPlayerOne($user_5->getUsername());
        $pairing_3_t1->setResultPlayerTwo($user_5->getUsername());
        $pairing_3_t1->setWinner($user_5);
        $pairing_3_t1->setRound(1);
        $pairing_3_t1->setTournament($tournament_1);

        $manager->persist($pairing_3_t1);

        $pairing_4_t1 = new TournamentPairing();
        $pairing_4_t1->setPlayerOne($user_7);
        $pairing_4_t1->setPlayerTwo($user_8);
        $pairing_4_t1->setResultPlayerOne($user_7->getUsername());
        $pairing_4_t1->setResultPlayerTwo($user_7->getUsername());
        $pairing_4_t1->setWinner($user_7);
        $pairing_4_t1->setRound(1);
        $pairing_4_t1->setTournament($tournament_1);

        $manager->persist($pairing_4_t1);

        $pairing_5_t1 = new TournamentPairing();
        $pairing_5_t1->setPlayerOne($user_1);
        $pairing_5_t1->setPlayerTwo($user_3);
        $pairing_5_t1->setResultPlayerOne($user_3->getUsername());
        $pairing_5_t1->setResultPlayerTwo($user_3->getUsername());
        $pairing_5_t1->setWinner($user_3);
        $pairing_5_t1->setRound(2);
        $pairing_5_t1->setTournament($tournament_1);

        $manager->persist($pairing_5_t1);

        $pairing_6_t1 = new TournamentPairing();
        $pairing_6_t1->setPlayerOne($user_5);
        $pairing_6_t1->setPlayerTwo($user_7);
        $pairing_6_t1->setResultPlayerOne($user_7->getUsername());
        $pairing_6_t1->setResultPlayerTwo($user_7->getUsername());
        $pairing_6_t1->setWinner($user_7);
        $pairing_6_t1->setRound(2);
        $pairing_6_t1->setTournament($tournament_1);

        $manager->persist($pairing_6_t1);

        $pairing_7_t1 = new TournamentPairing();
        $pairing_7_t1->setPlayerOne($user_3);
        $pairing_7_t1->setPlayerTwo($user_7);
        $pairing_7_t1->setResultPlayerOne($user_7->getUsername());
        $pairing_7_t1->setResultPlayerTwo($user_7->getUsername());
        $pairing_7_t1->setWinner($user_7);
        $pairing_7_t1->setRound(3);
        $pairing_7_t1->setTournament($tournament_1);

        $manager->persist($pairing_7_t1);
        
        // Emparejamientos torneo 2
        $pairing_1_t2 = new TournamentPairing();
        $pairing_1_t2->setPlayerOne($user_9);
        $pairing_1_t2->setPlayerTwo($user_10);
        $pairing_1_t2->setResultPlayerOne($user_9->getUsername());
        $pairing_1_t2->setResultPlayerTwo($user_9->getUsername());
        $pairing_1_t2->setWinner($user_9);
        $pairing_1_t2->setRound(1);
        $pairing_1_t2->setTournament($tournament_2);

        $manager->persist($pairing_1_t2);

        $pairing_2_t2 = new TournamentPairing();
        $pairing_2_t2->setPlayerOne($user_1);
        $pairing_2_t2->setPlayerTwo($user_2);
        $pairing_2_t2->setResultPlayerOne($user_1->getUsername());
        $pairing_2_t2->setResultPlayerTwo($user_1->getUsername());
        $pairing_2_t2->setWinner($user_1);
        $pairing_2_t2->setRound(1);
        $pairing_2_t2->setTournament($tournament_2);

        $manager->persist($pairing_2_t2);

        $pairing_3_t2 = new TournamentPairing();
        $pairing_3_t2->setPlayerOne($user_9);
        $pairing_3_t2->setPlayerTwo($user_1);
        $pairing_3_t2->setResultPlayerOne($user_1->getUsername());
        $pairing_3_t2->setResultPlayerTwo($user_1->getUsername());
        $pairing_3_t2->setWinner($user_1);
        $pairing_3_t2->setRound(2);
        $pairing_3_t2->setTournament($tournament_2);

        $manager->persist($pairing_3_t2);
        
        // Emparejamientos torneo 3
        $pairing_1_t3 = new TournamentPairing();
        $pairing_1_t3->setPlayerOne($user_3);
        $pairing_1_t3->setPlayerTwo($user_4);
        $pairing_1_t3->setResultPlayerOne($user_3->getUsername());
        $pairing_1_t3->setResultPlayerTwo($user_3->getUsername());
        $pairing_1_t3->setWinner($user_3);
        $pairing_1_t3->setRound(1);
        $pairing_1_t3->setTournament($tournament_3);

        $manager->persist($pairing_1_t3);

        $pairing_2_t3 = new TournamentPairing();
        $pairing_2_t3->setPlayerOne($user_5);
        $pairing_2_t3->setPlayerTwo($user_6);
        $pairing_2_t3->setResultPlayerOne($user_5->getUsername());
        $pairing_2_t3->setResultPlayerTwo($user_5->getUsername());
        $pairing_2_t3->setWinner($user_5);
        $pairing_2_t3->setRound(1);
        $pairing_2_t3->setTournament($tournament_3);

        $manager->persist($pairing_2_t3);

        $pairing_3_t3 = new TournamentPairing();
        $pairing_3_t3->setPlayerOne($user_7);
        $pairing_3_t3->setPlayerTwo($user_8);
        $pairing_3_t3->setResultPlayerOne($user_7->getUsername());
        $pairing_3_t3->setResultPlayerTwo($user_7->getUsername());
        $pairing_3_t3->setWinner($user_7);
        $pairing_3_t3->setRound(1);
        $pairing_3_t3->setTournament($tournament_3);

        $manager->persist($pairing_3_t3);

        $pairing_4_t3 = new TournamentPairing();
        $pairing_4_t3->setPlayerOne($user_3);
        $pairing_4_t3->setPlayerTwo($user_5);
        $pairing_4_t3->setResultPlayerOne($user_5->getUsername());
        $pairing_4_t3->setResultPlayerTwo($user_5->getUsername());
        $pairing_4_t3->setWinner($user_5);
        $pairing_4_t3->setRound(2);
        $pairing_4_t3->setTournament($tournament_3);

        $manager->persist($pairing_4_t3);

        $pairing_5_t3 = new TournamentPairing();
        $pairing_5_t3->setPlayerOne($user_7);
        $pairing_5_t3->setPlayerTwo($user_7);
        $pairing_5_t3->setResultPlayerOne($user_7->getUsername());
        $pairing_5_t3->setResultPlayerTwo($user_7->getUsername());
        $pairing_5_t3->setWinner($user_7);
        $pairing_5_t3->setRound(2);
        $pairing_5_t3->setTournament($tournament_3);

        $manager->persist($pairing_5_t3);

        $pairing_6_t3 = new TournamentPairing();
        $pairing_6_t3->setPlayerOne($user_5);
        $pairing_6_t3->setPlayerTwo($user_7);
        $pairing_6_t3->setResultPlayerOne($user_5->getUsername());
        $pairing_6_t3->setResultPlayerTwo($user_5->getUsername());
        $pairing_6_t3->setWinner($user_5);
        $pairing_6_t3->setRound(3);
        $pairing_6_t3->setTournament($tournament_3);

        $manager->persist($pairing_6_t3);
        
        // Emparejamientos torneo 4
        $pairing_1_t4 = new TournamentPairing();
        $pairing_1_t4->setPlayerOne($user_9);
        $pairing_1_t4->setPlayerTwo($user_10);
        $pairing_1_t4->setResultPlayerOne($user_9->getUsername());
        $pairing_1_t4->setResultPlayerTwo($user_9->getUsername());
        $pairing_1_t4->setWinner($user_9);
        $pairing_1_t4->setRound(1);
        $pairing_1_t4->setTournament($tournament_4);

        $manager->persist($pairing_1_t4);

        $pairing_2_t4 = new TournamentPairing();
        $pairing_2_t4->setPlayerOne($user_1);
        $pairing_2_t4->setPlayerTwo($user_2);
        $pairing_2_t4->setResultPlayerOne($user_2->getUsername());
        $pairing_2_t4->setResultPlayerTwo($user_2->getUsername());
        $pairing_2_t4->setWinner($user_2);
        $pairing_2_t4->setRound(1);
        $pairing_2_t4->setTournament($tournament_4);

        $manager->persist($pairing_2_t4);

        $pairing_3_t4 = new TournamentPairing();
        $pairing_3_t4->setPlayerOne($user_3);
        $pairing_3_t4->setPlayerTwo($user_4);
        $pairing_3_t4->setResultPlayerOne($user_4->getUsername());
        $pairing_3_t4->setResultPlayerTwo($user_4->getUsername());
        $pairing_3_t4->setWinner($user_4);
        $pairing_3_t4->setRound(1);
        $pairing_3_t4->setTournament($tournament_4);

        $manager->persist($pairing_3_t4);

        $pairing_4_t4 = new TournamentPairing();
        $pairing_4_t4->setPlayerOne($user_5);
        $pairing_4_t4->setPlayerTwo($user_6);
        $pairing_4_t4->setResultPlayerOne($user_5->getUsername());
        $pairing_4_t4->setResultPlayerTwo($user_5->getUsername());
        $pairing_4_t4->setWinner($user_5);
        $pairing_4_t4->setRound(1);
        $pairing_4_t4->setTournament($tournament_4);

        $manager->persist($pairing_4_t4);

        $pairing_5_t4 = new TournamentPairing();
        $pairing_5_t4->setPlayerOne($user_9);
        $pairing_5_t4->setPlayerTwo($user_2);
        $pairing_5_t4->setResultPlayerOne($user_9->getUsername());
        $pairing_5_t4->setResultPlayerTwo($user_9->getUsername());
        $pairing_5_t4->setWinner($user_9);
        $pairing_5_t4->setRound(2);
        $pairing_5_t4->setTournament($tournament_4);

        $manager->persist($pairing_5_t4);

        $pairing_6_t4 = new TournamentPairing();
        $pairing_6_t4->setPlayerOne($user_4);
        $pairing_6_t4->setPlayerTwo($user_5);
        $pairing_6_t4->setResultPlayerOne($user_5->getUsername());
        $pairing_6_t4->setResultPlayerTwo($user_5->getUsername());
        $pairing_6_t4->setWinner($user_5);
        $pairing_6_t4->setRound(2);
        $pairing_6_t4->setTournament($tournament_4);

        $manager->persist($pairing_6_t4);

        $pairing_7_t4 = new TournamentPairing();
        $pairing_7_t4->setPlayerOne($user_9);
        $pairing_7_t4->setPlayerTwo($user_5);
        $pairing_7_t4->setResultPlayerOne($user_5->getUsername());
        $pairing_7_t4->setResultPlayerTwo($user_5->getUsername());
        $pairing_7_t4->setWinner($user_5);
        $pairing_7_t4->setRound(3);
        $pairing_7_t4->setTournament($tournament_4);

        $manager->persist($pairing_7_t4);
        
        // Emparejamientos torneo 5
        $pairing_1_t5 = new TournamentPairing();
        $pairing_1_t5->setPlayerOne($user_7);
        $pairing_1_t5->setPlayerTwo($user_8);
        $pairing_1_t5->setResultPlayerOne($user_7->getUsername());
        $pairing_1_t5->setResultPlayerTwo($user_7->getUsername());
        $pairing_1_t5->setWinner($user_7);
        $pairing_1_t5->setRound(1);
        $pairing_1_t5->setTournament($tournament_5);

        $manager->persist($pairing_1_t5);

        $pairing_2_t5 = new TournamentPairing();
        $pairing_2_t5->setPlayerOne($user_9);
        $pairing_2_t5->setPlayerTwo($user_10);
        $pairing_2_t5->setResultPlayerOne($user_10->getUsername());
        $pairing_2_t5->setResultPlayerTwo($user_10->getUsername());
        $pairing_2_t5->setWinner($user_10);
        $pairing_2_t5->setRound(1);
        $pairing_2_t5->setTournament($tournament_5);

        $manager->persist($pairing_2_t5);

        $pairing_3_t5 = new TournamentPairing();
        $pairing_3_t5->setPlayerOne($user_1);
        $pairing_3_t5->setPlayerTwo($user_2);
        $pairing_3_t5->setResultPlayerOne($user_2->getUsername());
        $pairing_3_t5->setResultPlayerTwo($user_2->getUsername());
        $pairing_3_t5->setWinner($user_2);
        $pairing_3_t5->setRound(1);
        $pairing_3_t5->setTournament($tournament_5);

        $manager->persist($pairing_3_t5);

        $pairing_4_t5 = new TournamentPairing();
        $pairing_4_t5->setPlayerOne($user_3);
        $pairing_4_t5->setPlayerTwo($user_3);
        $pairing_4_t5->setWinner($user_3);
        $pairing_4_t5->setRound(1);
        $pairing_4_t5->setTournament($tournament_5);

        $manager->persist($pairing_4_t5);

        $pairing_5_t5 = new TournamentPairing();
        $pairing_5_t5->setPlayerOne($user_7);
        $pairing_5_t5->setPlayerTwo($user_10);
        $pairing_5_t5->setResultPlayerOne($user_7->getUsername());
        $pairing_5_t5->setResultPlayerTwo($user_7->getUsername());
        $pairing_5_t5->setWinner($user_7);
        $pairing_5_t5->setRound(2);
        $pairing_5_t5->setTournament($tournament_5);

        $manager->persist($pairing_5_t5);

        $pairing_6_t5 = new TournamentPairing();
        $pairing_6_t5->setPlayerOne($user_2);
        $pairing_6_t5->setPlayerTwo($user_3);
        $pairing_6_t5->setResultPlayerOne($user_2->getUsername());
        $pairing_6_t5->setResultPlayerTwo($user_2->getUsername());
        $pairing_6_t5->setWinner($user_2);
        $pairing_6_t5->setRound(2);
        $pairing_6_t5->setTournament($tournament_5);

        $manager->persist($pairing_6_t5);

        $pairing_7_t5 = new TournamentPairing();
        $pairing_7_t5->setPlayerOne($user_7);
        $pairing_7_t5->setPlayerTwo($user_2);
        $pairing_7_t5->setResultPlayerOne($user_7->getUsername());
        $pairing_7_t5->setResultPlayerTwo($user_7->getUsername());
        $pairing_7_t5->setWinner($user_7);
        $pairing_7_t5->setRound(3);
        $pairing_7_t5->setTournament($tournament_5);

        $manager->persist($pairing_7_t5);
        
        // Emparejamientos torneo 6
        $pairing_1_t6 = new TournamentPairing();
        $pairing_1_t6->setPlayerOne($user_4);
        $pairing_1_t6->setPlayerTwo($user_5);
        $pairing_1_t6->setResultPlayerOne($user_5->getUsername());
        $pairing_1_t6->setResultPlayerTwo($user_5->getUsername());
        $pairing_1_t6->setWinner($user_5);
        $pairing_1_t6->setRound(1);
        $pairing_1_t6->setTournament($tournament_6);

        $manager->persist($pairing_1_t6);

        $pairing_2_t6 = new TournamentPairing();
        $pairing_2_t6->setPlayerOne($user_6);
        $pairing_2_t6->setPlayerTwo($user_7);
        $pairing_2_t6->setResultPlayerOne($user_6->getUsername());
        $pairing_2_t6->setResultPlayerTwo($user_6->getUsername());
        $pairing_2_t6->setWinner($user_6);
        $pairing_2_t6->setRound(1);
        $pairing_2_t6->setTournament($tournament_6);

        $manager->persist($pairing_2_t6);

        $pairing_3_t6 = new TournamentPairing();
        $pairing_3_t6->setPlayerOne($user_5);
        $pairing_3_t6->setPlayerTwo($user_6);
        $pairing_3_t6->setResultPlayerOne($user_5->getUsername());
        $pairing_3_t6->setResultPlayerTwo($user_5->getUsername());
        $pairing_3_t6->setWinner($user_5);
        $pairing_3_t6->setRound(2);
        $pairing_3_t6->setTournament($tournament_6);

        $manager->persist($pairing_3_t6);
        
        // Emparejamientos torneo 7
        $pairing_1_t7 = new TournamentPairing();
        $pairing_1_t7->setPlayerOne($user_8);
        $pairing_1_t7->setPlayerTwo($user_9);
        $pairing_1_t7->setResultPlayerOne($user_8->getUsername());
        $pairing_1_t7->setResultPlayerTwo($user_8->getUsername());
        $pairing_1_t7->setWinner($user_8);
        $pairing_1_t7->setRound(1);
        $pairing_1_t7->setTournament($tournament_7);

        $manager->persist($pairing_1_t7);

        $pairing_2_t7 = new TournamentPairing();
        $pairing_2_t7->setPlayerOne($user_10);
        $pairing_2_t7->setPlayerTwo($user_1);
        $pairing_2_t7->setResultPlayerOne($user_10->getUsername());
        $pairing_2_t7->setResultPlayerTwo($user_10->getUsername());
        $pairing_2_t7->setWinner($user_10);
        $pairing_2_t7->setRound(1);
        $pairing_2_t7->setTournament($tournament_7);

        $manager->persist($pairing_2_t7);

        $pairing_3_t7 = new TournamentPairing();
        $pairing_3_t7->setPlayerOne($user_8);
        $pairing_3_t7->setPlayerTwo($user_10);
        $pairing_3_t7->setResultPlayerOne($user_8->getUsername());
        $pairing_3_t7->setResultPlayerTwo($user_8->getUsername());
        $pairing_3_t7->setWinner($user_8);
        $pairing_3_t7->setRound(2);
        $pairing_3_t7->setTournament($tournament_7);

        $manager->persist($pairing_3_t7);
        
        // Emparejamientos torneo 8
        $pairing_1_t8 = new TournamentPairing();
        $pairing_1_t8->setPlayerOne($user_2);
        $pairing_1_t8->setPlayerTwo($user_3);
        $pairing_1_t8->setResultPlayerOne($user_2->getUsername());
        $pairing_1_t8->setResultPlayerTwo($user_2->getUsername());
        $pairing_1_t8->setWinner($user_2);
        $pairing_1_t8->setRound(1);
        $pairing_1_t8->setTournament($tournament_8);

        $manager->persist($pairing_1_t8);

        $pairing_2_t8 = new TournamentPairing();
        $pairing_2_t8->setPlayerOne($user_4);
        $pairing_2_t8->setPlayerTwo($user_5);
        $pairing_2_t8->setResultPlayerOne($user_4->getUsername());
        $pairing_2_t8->setResultPlayerTwo($user_4->getUsername());
        $pairing_2_t8->setWinner($user_4);
        $pairing_2_t8->setRound(1);
        $pairing_2_t8->setTournament($tournament_8);

        $manager->persist($pairing_2_t8);

        $pairing_3_t8 = new TournamentPairing();
        $pairing_3_t8->setPlayerOne($user_6);
        $pairing_3_t8->setPlayerTwo($user_6);
        $pairing_3_t8->setWinner($user_6);
        $pairing_3_t8->setRound(1);
        $pairing_3_t8->setTournament($tournament_8);

        $manager->persist($pairing_3_t8);

        $pairing_4_t8 = new TournamentPairing();
        $pairing_4_t8->setPlayerOne($user_2);
        $pairing_4_t8->setPlayerTwo($user_4);
        $pairing_4_t8->setResultPlayerOne($user_4->getUsername());
        $pairing_4_t8->setResultPlayerTwo($user_4->getUsername());
        $pairing_4_t8->setWinner($user_4);
        $pairing_4_t8->setRound(2);
        $pairing_4_t8->setTournament($tournament_8);

        $manager->persist($pairing_4_t8);

        $pairing_5_t8 = new TournamentPairing();
        $pairing_5_t8->setPlayerOne($user_6);
        $pairing_5_t8->setPlayerTwo($user_6);
        $pairing_5_t8->setWinner($user_6);
        $pairing_5_t8->setRound(2);
        $pairing_5_t8->setTournament($tournament_8);

        $manager->persist($pairing_5_t8);

        $pairing_6_t8 = new TournamentPairing();
        $pairing_6_t8->setPlayerOne($user_4);
        $pairing_6_t8->setPlayerTwo($user_6);
        $pairing_6_t8->setResultPlayerOne($user_4->getUsername());
        $pairing_6_t8->setResultPlayerTwo($user_4->getUsername());
        $pairing_6_t8->setWinner($user_4);
        $pairing_6_t8->setRound(3);
        $pairing_6_t8->setTournament($tournament_8);

        $manager->persist($pairing_6_t8);
        
        // Emparejamientos torneo 9
        $pairing_1_t9 = new TournamentPairing();
        $pairing_1_t9->setPlayerOne($user_7);
        $pairing_1_t9->setPlayerTwo($user_8);
        $pairing_1_t9->setResultPlayerOne($user_7->getUsername());
        $pairing_1_t9->setResultPlayerTwo($user_7->getUsername());
        $pairing_1_t9->setWinner($user_7);
        $pairing_1_t9->setRound(1);
        $pairing_1_t9->setTournament($tournament_9);

        $manager->persist($pairing_1_t9);

        $pairing_2_t9 = new TournamentPairing();
        $pairing_2_t9->setPlayerOne($user_9);
        $pairing_2_t9->setPlayerTwo($user_10);
        $pairing_2_t9->setResultPlayerOne($user_9->getUsername());
        $pairing_2_t9->setResultPlayerTwo($user_9->getUsername());
        $pairing_2_t9->setWinner($user_9);
        $pairing_2_t9->setRound(1);
        $pairing_2_t9->setTournament($tournament_9);

        $manager->persist($pairing_2_t9);

        $pairing_3_t9 = new TournamentPairing();
        $pairing_3_t9->setPlayerOne($user_1);
        $pairing_3_t9->setPlayerTwo($user_2);
        $pairing_3_t9->setResultPlayerOne($user_1->getUsername());
        $pairing_3_t9->setResultPlayerTwo($user_1->getUsername());
        $pairing_3_t9->setWinner($user_1);
        $pairing_3_t9->setRound(1);
        $pairing_3_t9->setTournament($tournament_9);

        $manager->persist($pairing_3_t9);

        $pairing_4_t9 = new TournamentPairing();
        $pairing_4_t9->setPlayerOne($user_3);
        $pairing_4_t9->setPlayerTwo($user_4);
        $pairing_4_t9->setResultPlayerOne($user_3->getUsername());
        $pairing_4_t9->setResultPlayerTwo($user_3->getUsername());
        $pairing_4_t9->setWinner($user_3);
        $pairing_4_t9->setRound(1);
        $pairing_4_t9->setTournament($tournament_9);

        $manager->persist($pairing_4_t9);

        $pairing_5_t9 = new TournamentPairing();
        $pairing_5_t9->setPlayerOne($user_7);
        $pairing_5_t9->setPlayerTwo($user_9);
        $pairing_5_t9->setResultPlayerOne($user_7->getUsername());
        $pairing_5_t9->setResultPlayerTwo($user_7->getUsername());
        $pairing_5_t9->setWinner($user_7);
        $pairing_5_t9->setRound(2);
        $pairing_5_t9->setTournament($tournament_9);

        $manager->persist($pairing_5_t9);

        $pairing_6_t9 = new TournamentPairing();
        $pairing_6_t9->setPlayerOne($user_1);
        $pairing_6_t9->setPlayerTwo($user_3);
        $pairing_6_t9->setResultPlayerOne($user_3->getUsername());
        $pairing_6_t9->setResultPlayerTwo($user_3->getUsername());
        $pairing_6_t9->setWinner($user_3);
        $pairing_6_t9->setRound(2);
        $pairing_6_t9->setTournament($tournament_9);

        $manager->persist($pairing_6_t9);

        $pairing_7_t9 = new TournamentPairing();
        $pairing_7_t9->setPlayerOne($user_7);
        $pairing_7_t9->setPlayerTwo($user_3);
        $pairing_7_t9->setResultPlayerOne($user_3->getUsername());
        $pairing_7_t9->setResultPlayerTwo($user_3->getUsername());
        $pairing_7_t9->setWinner($user_3);
        $pairing_7_t9->setRound(3);
        $pairing_7_t9->setTournament($tournament_9);

        $manager->persist($pairing_7_t9);
        
        // Emparejamientos torneo 10
        $pairing_1_t10 = new TournamentPairing();
        $pairing_1_t10->setPlayerOne($user_5);
        $pairing_1_t10->setPlayerTwo($user_6);
        $pairing_1_t10->setResultPlayerOne($user_6->getUsername());
        $pairing_1_t10->setResultPlayerTwo($user_6->getUsername());
        $pairing_1_t10->setWinner($user_6);
        $pairing_1_t10->setRound(1);
        $pairing_1_t10->setTournament($tournament_10);

        $manager->persist($pairing_1_t10);

        $pairing_2_t10 = new TournamentPairing();
        $pairing_2_t10->setPlayerOne($user_7);
        $pairing_2_t10->setPlayerTwo($user_8);
        $pairing_2_t10->setResultPlayerOne($user_8->getUsername());
        $pairing_2_t10->setResultPlayerTwo($user_8->getUsername());
        $pairing_2_t10->setWinner($user_9);
        $pairing_2_t10->setRound(1);
        $pairing_2_t10->setTournament($tournament_10);

        $manager->persist($pairing_2_t10);

        $pairing_3_t10 = new TournamentPairing();
        $pairing_3_t10->setPlayerOne($user_9);
        $pairing_3_t10->setPlayerTwo($user_10);
        $pairing_3_t10->setResultPlayerOne($user_9->getUsername());
        $pairing_3_t10->setResultPlayerTwo($user_9->getUsername());
        $pairing_3_t10->setWinner($user_1);
        $pairing_3_t10->setRound(1);
        $pairing_3_t10->setTournament($tournament_10);

        $manager->persist($pairing_3_t10);

        $pairing_4_t10 = new TournamentPairing();
        $pairing_4_t10->setPlayerOne($user_1);
        $pairing_4_t10->setPlayerTwo($user_2);
        $pairing_4_t10->setResultPlayerOne($user_2->getUsername());
        $pairing_4_t10->setResultPlayerTwo($user_2->getUsername());
        $pairing_4_t10->setWinner($user_2);
        $pairing_4_t10->setRound(1);
        $pairing_4_t10->setTournament($tournament_10);

        $manager->persist($pairing_4_t10);

        $pairing_5_t10 = new TournamentPairing();
        $pairing_5_t10->setPlayerOne($user_3);
        $pairing_5_t10->setPlayerTwo($user_3);
        $pairing_5_t10->setWinner($user_3);
        $pairing_5_t10->setRound(1);
        $pairing_5_t10->setTournament($tournament_10);

        $manager->persist($pairing_5_t10);

        $pairing_6_t10 = new TournamentPairing();
        $pairing_6_t10->setPlayerOne($user_6);
        $pairing_6_t10->setPlayerTwo($user_9);
        $pairing_6_t10->setResultPlayerOne($user_9->getUsername());
        $pairing_6_t10->setResultPlayerTwo($user_9->getUsername());
        $pairing_6_t10->setWinner($user_9);
        $pairing_6_t10->setRound(2);
        $pairing_6_t10->setTournament($tournament_10);

        $manager->persist($pairing_6_t10);

        $pairing_7_t10 = new TournamentPairing();
        $pairing_7_t10->setPlayerOne($user_1);
        $pairing_7_t10->setPlayerTwo($user_2);
        $pairing_7_t10->setResultPlayerOne($user_2->getUsername());
        $pairing_7_t10->setResultPlayerTwo($user_2->getUsername());
        $pairing_7_t10->setWinner($user_2);
        $pairing_7_t10->setRound(2);
        $pairing_7_t10->setTournament($tournament_10);

        $manager->persist($pairing_7_t10);

        $pairing_8_t10 = new TournamentPairing();
        $pairing_8_t10->setPlayerOne($user_3);
        $pairing_8_t10->setPlayerTwo($user_3);
        $pairing_8_t10->setWinner($user_3);
        $pairing_8_t10->setRound(2);
        $pairing_8_t10->setTournament($tournament_10);

        $manager->persist($pairing_8_t10);

        $pairing_9_t10 = new TournamentPairing();
        $pairing_9_t10->setPlayerOne($user_9);
        $pairing_9_t10->setPlayerTwo($user_2);
        $pairing_9_t10->setResultPlayerOne($user_2->getUsername());
        $pairing_9_t10->setResultPlayerTwo($user_2->getUsername());
        $pairing_9_t10->setWinner($user_2);
        $pairing_9_t10->setRound(3);
        $pairing_9_t10->setTournament($tournament_10);

        $manager->persist($pairing_9_t10);

        $pairing_10_t10 = new TournamentPairing();
        $pairing_10_t10->setPlayerOne($user_3);
        $pairing_10_t10->setPlayerTwo($user_3);
        $pairing_10_t10->setWinner($user_3);
        $pairing_10_t10->setRound(3);
        $pairing_10_t10->setTournament($tournament_10);

        $manager->persist($pairing_10_t10);

        $pairing_11_t10 = new TournamentPairing();
        $pairing_11_t10->setPlayerOne($user_2);
        $pairing_11_t10->setPlayerTwo($user_3);
        $pairing_11_t10->setResultPlayerOne($user_2->getUsername());
        $pairing_11_t10->setResultPlayerTwo($user_2->getUsername());
        $pairing_11_t10->setWinner($user_2);
        $pairing_11_t10->setRound(4);
        $pairing_11_t10->setTournament($tournament_10);

        $manager->persist($pairing_11_t10);
        
        // Emparejamientos torneo 11
        $pairing_1_t11 = new TournamentPairing();
        $pairing_1_t11->setPlayerOne($user_4);
        $pairing_1_t11->setPlayerTwo($user_5);
        $pairing_1_t11->setResultPlayerOne($user_4->getUsername());
        $pairing_1_t11->setResultPlayerTwo($user_4->getUsername());
        $pairing_1_t11->setWinner($user_4);
        $pairing_1_t11->setRound(1);
        $pairing_1_t11->setTournament($tournament_11);

        $manager->persist($pairing_1_t11);

        $pairing_2_t11 = new TournamentPairing();
        $pairing_2_t11->setPlayerOne($user_6);
        $pairing_2_t11->setPlayerTwo($user_6);
        $pairing_2_t11->setWinner($user_6);
        $pairing_2_t11->setRound(1);
        $pairing_2_t11->setTournament($tournament_11);

        $manager->persist($pairing_2_t11);

        $pairing_3_t11 = new TournamentPairing();
        $pairing_3_t11->setPlayerOne($user_4);
        $pairing_3_t11->setPlayerTwo($user_6);
        $pairing_3_t11->setResultPlayerOne($user_4->getUsername());
        $pairing_3_t11->setResultPlayerTwo($user_4->getUsername());
        $pairing_3_t11->setWinner($user_4);
        $pairing_3_t11->setRound(2);
        $pairing_3_t11->setTournament($tournament_11);

        $manager->persist($pairing_3_t11);
        
        // Emparejamientos torneo 12
        $pairing_1_t12 = new TournamentPairing();
        $pairing_1_t12->setPlayerOne($user_7);
        $pairing_1_t12->setPlayerTwo($user_8);
        $pairing_1_t12->setResultPlayerOne($user_7->getUsername());
        $pairing_1_t12->setResultPlayerTwo($user_7->getUsername());
        $pairing_1_t12->setWinner($user_7);
        $pairing_1_t12->setRound(1);
        $pairing_1_t12->setTournament($tournament_12);

        $manager->persist($pairing_1_t12);

        $pairing_2_t12 = new TournamentPairing();
        $pairing_2_t12->setPlayerOne($user_9);
        $pairing_2_t12->setPlayerTwo($user_10);
        $pairing_2_t12->setResultPlayerOne($user_9->getUsername());
        $pairing_2_t12->setResultPlayerTwo($user_9->getUsername());
        $pairing_2_t12->setWinner($user_9);
        $pairing_2_t12->setRound(1);
        $pairing_2_t12->setTournament($tournament_12);

        $manager->persist($pairing_2_t12);

        $pairing_3_t12 = new TournamentPairing();
        $pairing_3_t12->setPlayerOne($user_7);
        $pairing_3_t12->setPlayerTwo($user_10);
        $pairing_3_t12->setRound(2);
        $pairing_3_t12->setTournament($tournament_12);

        $manager->persist($pairing_3_t12);
        
        // Emparejamientos torneo 13
        $pairing_1_t13 = new TournamentPairing();
        $pairing_1_t13->setPlayerOne($user_1);
        $pairing_1_t13->setPlayerTwo($user_2);
        $pairing_1_t13->setResultPlayerOne($user_1->getUsername());
        $pairing_1_t13->setResultPlayerTwo($user_1->getUsername());
        $pairing_1_t13->setWinner($user_1);
        $pairing_1_t13->setRound(1);
        $pairing_1_t13->setTournament($tournament_13);

        $manager->persist($pairing_1_t13);

        $pairing_2_t13 = new TournamentPairing();
        $pairing_2_t13->setPlayerOne($user_3);
        $pairing_2_t13->setPlayerTwo($user_3);
        $pairing_2_t13->setWinner($user_3);
        $pairing_2_t13->setRound(1);
        $pairing_2_t13->setTournament($tournament_13);

        $manager->persist($pairing_2_t13);

        $pairing_3_t13 = new TournamentPairing();
        $pairing_3_t13->setPlayerOne($user_1);
        $pairing_3_t13->setPlayerTwo($user_3);
        $pairing_3_t13->setRound(2);
        $pairing_3_t13->setTournament($tournament_13);

        $manager->persist($pairing_3_t13);
        
        // Emparejamientos torneo 14
        $pairing_1_t14 = new TournamentPairing();
        $pairing_1_t14->setPlayerOne($user_4);
        $pairing_1_t14->setPlayerTwo($user_5);
        $pairing_1_t14->setResultPlayerOne($user_5->getUsername());
        $pairing_1_t14->setResultPlayerTwo($user_5->getUsername());
        $pairing_1_t14->setWinner($user_5);
        $pairing_1_t14->setRound(1);
        $pairing_1_t14->setTournament($tournament_14);

        $manager->persist($pairing_1_t14);

        $pairing_2_t14 = new TournamentPairing();
        $pairing_2_t14->setPlayerOne($user_6);
        $pairing_2_t14->setPlayerTwo($user_7);
        $pairing_2_t14->setResultPlayerOne($user_6->getUsername());
        $pairing_2_t14->setResultPlayerTwo($user_6->getUsername());
        $pairing_2_t14->setWinner($user_6);
        $pairing_2_t14->setRound(1);
        $pairing_2_t14->setTournament($tournament_14);

        $manager->persist($pairing_2_t14);

        $pairing_3_t14 = new TournamentPairing();
        $pairing_3_t14->setPlayerOne($user_5);
        $pairing_3_t14->setPlayerTwo($user_6);
        $pairing_3_t14->setRound(2);
        $pairing_3_t14->setTournament($tournament_14);

        $manager->persist($pairing_3_t14);
        
        // Emparejamientos torneo 15
        $pairing_1_t15 = new TournamentPairing();
        $pairing_1_t15->setPlayerOne($user_8);
        $pairing_1_t15->setPlayerTwo($user_9);
        $pairing_1_t15->setResultPlayerOne($user_8->getUsername());
        $pairing_1_t15->setResultPlayerTwo($user_8->getUsername());
        $pairing_1_t15->setWinner($user_8);
        $pairing_1_t15->setRound(1);
        $pairing_1_t15->setTournament($tournament_15);

        $manager->persist($pairing_1_t15);

        $pairing_2_t15 = new TournamentPairing();
        $pairing_2_t15->setPlayerOne($user_10);
        $pairing_2_t15->setPlayerTwo($user_1);
        $pairing_2_t15->setResultPlayerOne($user_10->getUsername());
        $pairing_2_t15->setResultPlayerTwo($user_10->getUsername());
        $pairing_2_t15->setWinner($user_10);
        $pairing_2_t15->setRound(1);
        $pairing_2_t15->setTournament($tournament_15);

        $manager->persist($pairing_2_t15);

        $pairing_3_t15 = new TournamentPairing();
        $pairing_3_t15->setPlayerOne($user_8);
        $pairing_3_t15->setPlayerTwo($user_10);
        $pairing_3_t15->setRound(2);
        $pairing_3_t15->setTournament($tournament_15);

        $manager->persist($pairing_3_t15);

        $manager->flush();
    }

    private function createTournamentsRules(ObjectManager $manager) {
        $tournament_repository = $manager->getRepository(Tournament::class);

        $tournaments = $tournament_repository->findAll();

        foreach($tournaments as $tournament) {
            $rule_1 = new TournamentRule();
            $rule_2 = new TournamentRule();
            $rule_3 = new TournamentRule();
            $rule_4 = new TournamentRule();
            $rule_5 = new TournamentRule();

            $rule_1->setRule('Cada usuario deberá tener registrada su cuenta de juego');
            $rule_2->setRule('El usuario deberá ponerse en contacto con su contrincante');
            $rule_3->setRule('Si el usuario no envía un resultado, el moderador podrá darle la victoria a su contrincante');
            $rule_4->setRule('Cada usuario podrá inscribirse una única vez');
            $rule_5->setRule('En caso de no cumplir con las reglas, podrá invalidarse una partida');

            $rule_1->setTournament($tournament);
            $rule_2->setTournament($tournament);
            $rule_3->setTournament($tournament);
            $rule_4->setTournament($tournament);
            $rule_5->setTournament($tournament);

            $manager->persist($rule_1);
            $manager->persist($rule_2);
            $manager->persist($rule_3);
            $manager->persist($rule_4);
            $manager->persist($rule_5);

            $manager->flush();
        }
    }
}