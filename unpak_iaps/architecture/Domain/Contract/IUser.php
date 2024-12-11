<?php
namespace Architecture\Domain\Contract;

use Architecture\Domain\Entity\BaseEntity;
use Architecture\Domain\Shared\NamingEntity;

abstract class IUser extends BaseEntity{
    use NamingEntity;
    public $username;
    public $password = null;
    public $plain_password = null;
    public $level;

    public function GetUsername()
    {
        return $this->username;
    }
    public function GetPassword()
    {
        return $this->password;
    }
    public function GetPlainPassword()
    {
        return $this->plain_password;
    }
    public function GetLevel()
    {
        return $this->level;
    }
}