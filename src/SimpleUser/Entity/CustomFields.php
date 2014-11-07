<?php

namespace SimpleUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomFields
 *
 * @ORM\Table(name="user_custom_fields")
 * @ORM\Entity(repositoryClass="SimpleUser\Entity\CustomFieldsRepository")
 */
class CustomFields 
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \SimpleUser\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="CustomFields", cascade={"all"})
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute", type="string", length=50, nullable=false)
     */
    private $attribute = '';

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;

    public function __construct($user, $attribute, $value) {
        $this->setUser($user);
        $this->setAttribute($attribute);
        $this->setValue($value);
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return CustomFields
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set attribute
     *
     * @param string $attribute
     * @return CustomFields
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return string 
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return CustomFields
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->value;
    }
}
