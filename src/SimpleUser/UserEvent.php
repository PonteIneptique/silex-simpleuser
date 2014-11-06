<?php

namespace SimpleUser;

use Symfony\Component\EventDispatcher\Event;
use SimpleUser\Entity\User;

class UserEvent extends Event
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}