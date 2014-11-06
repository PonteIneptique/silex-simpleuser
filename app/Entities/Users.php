<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class Users
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string $salt
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * @var string $roles
     *
     * @ORM\Column(name="roles", type="string", length=255, nullable=false)
     */
    private $roles;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var integer $timeCreated
     *
     * @ORM\Column(name="time_created", type="integer", nullable=false)
     */
    private $timeCreated;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=true)
     */
    private $username;

    /**
     * @var boolean $isenabled
     *
     * @ORM\Column(name="isEnabled", type="boolean", nullable=false)
     */
    private $isenabled;

    /**
     * @var string $confirmationtoken
     *
     * @ORM\Column(name="confirmationToken", type="string", length=100, nullable=true)
     */
    private $confirmationtoken;

    /**
     * @var integer $timepasswordresetrequested
     *
     * @ORM\Column(name="timePasswordResetRequested", type="integer", nullable=true)
     */
    private $timepasswordresetrequested;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Users
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
     * Set password
     *
     * @param string $password
     * @return Users
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
     * Set salt
     *
     * @param string $salt
     * @return Users
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set roles
     *
     * @param string $roles
     * @return Users
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Get roles
     *
     * @return string 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Users
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set timeCreated
     *
     * @param integer $timeCreated
     * @return Users
     */
    public function setTimeCreated($timeCreated)
    {
        $this->timeCreated = $timeCreated;
        return $this;
    }

    /**
     * Get timeCreated
     *
     * @return integer 
     */
    public function getTimeCreated()
    {
        return $this->timeCreated;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Users
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
     * Set isenabled
     *
     * @param boolean $isenabled
     * @return Users
     */
    public function setIsenabled($isenabled)
    {
        $this->isenabled = $isenabled;
        return $this;
    }

    /**
     * Get isenabled
     *
     * @return boolean 
     */
    public function getIsenabled()
    {
        return $this->isenabled;
    }

    /**
     * Set confirmationtoken
     *
     * @param string $confirmationtoken
     * @return Users
     */
    public function setConfirmationtoken($confirmationtoken)
    {
        $this->confirmationtoken = $confirmationtoken;
        return $this;
    }

    /**
     * Get confirmationtoken
     *
     * @return string 
     */
    public function getConfirmationtoken()
    {
        return $this->confirmationtoken;
    }

    /**
     * Set timepasswordresetrequested
     *
     * @param integer $timepasswordresetrequested
     * @return Users
     */
    public function setTimepasswordresetrequested($timepasswordresetrequested)
    {
        $this->timepasswordresetrequested = $timepasswordresetrequested;
        return $this;
    }

    /**
     * Get timepasswordresetrequested
     *
     * @return integer 
     */
    public function getTimepasswordresetrequested()
    {
        return $this->timepasswordresetrequested;
    }
}