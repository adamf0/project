<?php

namespace Architecture\Application\User\Create;

use Architecture\Application\Abstractions\Messaging\Command;
use Architecture\Shared\NamingCommand;
use Architecture\Shared\TypeData;

class CreateUserCommand extends Command
{
    use NamingCommand;
    public function __construct(public $nama, public $username, public $password, public $level, public TypeData $option = TypeData::Entity) {}

    public function GetUsername(){
        return $this->username;
    }
    public function GetPassword(){
        return $this->password;
    }
    public function GetLevel(){
        return $this->level;
    }
}