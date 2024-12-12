<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Shared\NamingEntity;

class User extends BaseEntity{
    use NamingEntity;
    public function __construct(public $id=null,public $nama=null,public $username,public $password=null,public $plain_password=null,public $level){}

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