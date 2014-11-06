<?php

namespace SimpleUser\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * \Doctrine\ORM\Mapping\Entity
 * @ORM\Table(name="simple_user_user")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_created", type="integer")
     */
    private $timeCreated;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=true, unique=true)
     */
    private $username;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_enabled", type="boolean")
     */
    private $isEnabled = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string", length=100, nullable=true)
     */
    private $confirmationToken;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_password_reset_requested", type="integer", nullable=true)
     */
    private $timePasswordResetRequested;

    //protected $customFields = array();


    /**
     * Constructor.
     *
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
        $this->timeCreated = time();
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    /**
     * Set id
     *
     * @return integer 
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


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
     * Set password
     *
     * @param string $password
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
     * Set salt
     *
     * @param string $salt
     * @return User
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
     * Returns the roles granted to the user. Note that all users have the ROLE_USER role.
     *
     * @return array A list of the user's roles.
     */
    public function getRoles()
    {
        $roles = $this->roles;

        // Every user must have at least one role, per Silex security docs.
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Set the user's roles to the given list.
     *
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }

    /**
     * Test whether the user has the given role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * Add the given role to the user.
     *
     * @param string $role
     */
    public function addRole($role)
    {
        $role = strtoupper($role);

        if ($role === 'ROLE_USER') {
            return;
        }

        if (!$this->hasRole($role)) {
            $this->roles[] = $role;
        }
    }

    /**
     * Remove the given role from the user.
     *
     * @param string $role
     */
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * @return User
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
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }


    /**
     * Returns the username, if not empty, otherwise the email address.
     *
     * Email is returned as a fallback because username is optional,
     * but the Symfony Security system depends on getUsername() returning a value.
     * Use getRealUsername() to get the actual username value.
     *
     * This method is required by the UserInterface.
     *
     * @see getRealUsername
     * @return string The username, if not empty, otherwise the email.
     */
    public function getUsername()
    {
        return $this->username ?: $this->email;
    }

    /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     * @return User
     */
    public function setEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * Get isEnabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->isEnabled;
    }



    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     * @return User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string 
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set timePasswordResetRequested
     *
     * @param integer $timePasswordResetRequested
     * @return User
     */
    public function setTimepasswordresetrequested($timePasswordResetRequested)
    {
        $this->timePasswordResetRequested = $timePasswordResetRequested;

        return $this;
    }

    /**
     * Get timePasswordResetRequested
     *
     * @return integer 
     */
    public function TimePasswordResetRequested()
    {
        return $this->timePasswordResetRequested;
    }

    /**
     * Get the actual username value that was set,
     * or null if no username has been set.
     * Compare to getUsername, which returns the email if username is not set.
     *
     * @see getUsername
     * @return string|null
     */
    public function getRealUsername()
    {
        return $this->username;
    }

    /**
     * Test whether username has ever been set (even if it's currently empty).
     *
     * @return bool
     */
    public function hasRealUsername()
    {
        return !is_null($this->username);
    }

    /**
     * Returns the name, if set, or else "Anonymous {id}".
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->name ?: 'Anonymous ' . $this->id;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is a no-op, since we never store the plain text credentials in this object.
     * It's required by UserInterface.
     *
     * @return void
     */
    public function eraseCredentials()
    {
    }

    /**
     * The Symfony Security component stores a serialized User object in the session.
     * We only need it to store the user ID, because the user provider's refreshUser() method is called on each request
     * and reloads the user by its ID.
     *
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            ) = unserialize($serialized);
    }

    /**
     * Validate the user object.
     *
     * @return array An array of error messages, or an empty array if there were no errors.
     */
    public function validate()
    {
        $errors = array();

        if (!$this->getEmail()) {
            $errors['email'] = 'Email address is required.';
        } else if (!strpos($this->getEmail(), '@')) {
            // Basic email format sanity check. Real validation comes from sending them an email with a link they have to click.
            $errors['email'] = 'Email address appears to be invalid.';
        } else if (strlen($this->getEmail()) > 100) {
            $errors['email'] = 'Email address can\'t be longer than 100 characters.';
        }

        if (!$this->getPassword()) {
            $errors['password'] = 'Password is required.';
        } else if (strlen($this->getPassword()) > 255) {
            $errors['password'] = 'Password can\'t be longer than 255 characters.';
        }

        if (strlen($this->getName()) > 100) {
            $errors['name'] = 'Name can\'t be longer than 100 characters.';
        }

        // Username can't contain "@",
        // because that's how we distinguish between email and username when signing in.
        // (It's possible to sign in by providing either one.)
        if ($this->getRealUsername() && strpos($this->getRealUsername(), '@') !== false) {
            $errors['username'] = 'Username cannot contain the "@" symbol.';
        }

        return $errors;
    }
    
    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * Users are enabled by default.
     *
     * @return bool    true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool    true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool    true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool    true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * @param int $ttl Password reset request TTL, in seconds.
     * @return bool
     */
    public function isPasswordResetRequestExpired($ttl)
    {
        $timeRequested = $this->getTimePasswordResetRequested();
        if (!$timeRequested) {
            return true;
        }

        return $timeRequested + $ttl < time();
    }


    /**
     * @param string $customField
     * @return bool
     */
    public function hasCustomField($customField)
    {
        return array_key_exists($customField, $this->customFields);
    }

    /**
     * @param string $customField
     * @return mixed|null
     */
    public function getCustomField($customField)
    {
        return $this->hasCustomField($customField) ? $this->customFields[$customField] : null;
    }

    /**
     * @param string $customField
     * @param mixed $value
     */
    public function setCustomField($customField, $value)
    {
        $this->customFields[$customField] = $value;
    }

    /**
     * @param array|null $customFields
     */
    public function setCustomFields($customFields)
    {
        $this->customFields = $customFields;
    }

    /**
     * @return array
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }
}
