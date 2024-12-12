<?php

namespace Architecture\Application\Matriks\Update;

use Architecture\Application\Abstractions\Messaging\Command;
use Architecture\Shared\IdentityCommand;
use Architecture\Shared\NamingCommand;
use Architecture\Shared\TypeData;

class UpdateMatriksCommand extends Command
{
    use IdentityCommand,NamingCommand;
    public function __construct(public $id, public $nama, public $deskripsi, public TypeData $option = TypeData::Entity) {}

    public function GetDeskripsi(){
        return $this->deskripsi;
    }
}