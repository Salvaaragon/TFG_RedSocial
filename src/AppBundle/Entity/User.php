<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity("email", message="El correo electrónico introducido ya está registrado")
 * @UniqueEntity("username", message="El nombre de usuario introducido ya está registrado")
 */
class User implements AdvancedUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=32, unique=true)
     * @Assert\Length(min=6, 
     *                max=12, 
     *                minMessage="El nombre de usuario ha de tener mínimo 6 caracteres",
     *                maxMessage="El nombre de usuario ha de tener máximo 12 caracteres")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_name", type="string", length=64)
     * @Assert\Length(max=32, maxMessage="El nombre de perfil no puede tener más de 32 caracteres")
     */
    private $profileName;

    /**
     * @Assert\NotBlank(message="Las contraseñas no coinciden")
     * @Assert\Length(min=6,
     *                max=16, 
     *                minMessage="La contraseña ha de tener mínimo 6 caracteres",
     *                maxMessage="La contraseña ha de tener máximo 16 caracteres")
     */
    private $plainPassword;

    /**
     * @var string
     * 
     * @ORM\Column(name="password", type="string")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="steam_id", type="string", length=32, nullable=true)
     */
    private $steamId;

    /**
     * @var string
     *
     * @ORM\Column(name="xbox_id", type="string", length=32, nullable=true)
     */
    private $xboxId;

    /**
     * @var string
     *
     * @ORM\Column(name="psn_id", type="string", length=32, nullable=true)
     */
    private $psnId;

    /**
     * @ORM\Column(name="role", type="string")
     */
    private $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
    * @ORM\OneToMany(targetEntity="GameGroup", mappedBy="user")
    */
    private $game_groups;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="user")
     */
    private $posts;

    /**
    * @ORM\OneToMany(targetEntity="Message", mappedBy="user")
    */
    private $messages;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    public function __construct()
    {
        $this->roles = 'ROLE_USER';
        $this->isActive = false;
        $this->game_groups = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set profileName
     *
     * @param string $profileName
     *
     * @return User
     */
    public function setProfileName($profileName)
    {
        $this->profileName = $profileName;

        return $this;
    }

    /**
     * Get profileName
     *
     * @return string
     */
    public function getProfileName()
    {
        return $this->profileName;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set steamId
     *
     * @param string $steamId
     *
     * @return User
     */
    public function setSteamId($steamId)
    {
        $this->steamId = $steamId;

        return $this;
    }

    /**
     * Get steamId
     *
     * @return string
     */
    public function getSteamId()
    {
        return $this->steamId;
    }

    /**
     * Set xboxId
     *
     * @param string $xboxId
     *
     * @return User
     */
    public function setXboxId($xboxId)
    {
        $this->xboxId = $xboxId;

        return $this;
    }

    /**
     * Get xboxId
     *
     * @return string
     */
    public function getXboxId()
    {
        return $this->xboxId;
    }

    /**
     * Set psnId
     *
     * @param string $psnId
     *
     * @return User
     */
    public function setPsnId($psnId)
    {
        $this->psnId = $psnId;

        return $this;
    }

    /**
     * Get psnId
     *
     * @return string
     */
    public function getPsnId()
    {
        return $this->psnId;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Post
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get roles
     */
    public function getRoles()
    {
        return array($this->roles);
    }

    /**
     * Set isActive
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function getSteamGames() {
        if(isset($this->steamId)) {
            $json_userapikey = file_get_contents("http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=B04E1EB884D3702EBB032D4B90E97166&vanityurl=".$this->steamId);
            $decode_json_userapikey = json_decode($json_userapikey, true);
            $userapikey = $decode_json_userapikey['response']['steamid'];
            
            $json_gamesuser = file_get_contents("http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=B04E1EB884D3702EBB032D4B90E97166&steamid=".$userapikey."&format=json");
            $decode_json_gamesuser = json_decode($json_gamesuser, true);

            $num_games_user = $decode_json_gamesuser['response']['game_count'];

            for($i = 0; $i < $num_games_user; $i++)
                $games_id[$i] = $decode_json_gamesuser['response']['games'][$i]['appid'];

            for($j = 0; $j < $num_games_user; $j++) {
                $json_game = file_get_contents("http://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key=B04E1EB884D3702EBB032D4B90E97166&appid=".$games_id[$j]);
                $decode_json_game = json_decode($json_game, true);
                if(isset($decode_json_game['game']['gameName'])) {
                    $name_game = $decode_json_game['game']['gameName'];
                    if($name_game != "" && substr($name_game, 0, 9) != "ValveTest") {
                        $games_name[$name_game] = $name_game;
                    }
                }
            }
            return $games_name;
        }
    }
}

