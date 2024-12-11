<?php

namespace Architecture\Application\User\Update;

use Architecture\Application\Abstractions\Messaging\Command;
use Architecture\Shared\IdentityCommand;
use Architecture\Shared\NamingCommand;
use Architecture\Shared\TypeData;

class UpdateUserCommand extends Command
{
    use IdentityCommand,NamingCommand;
    public function __construct(public $id, public $nama, public $username, public $password, public $level, public TypeData $option = TypeData::Entity) {}

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