<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

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
     * @ORM\Column(name="id", type="integer", length=32)
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

    public function __construct()
    {
        $this->roles = 'ROLE_USER';
        $this->isActive = false;
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
}

