<?php

namespace Architecture\Application\Matriks\Create;

use Architecture\Application\Abstractions\Messaging\Command;
use Architecture\Shared\NamingCommand;
use Architecture\Shared\TypeData;

class CreateMatriksCommand extends Command
{
    use NamingCommand;
    public function __construct(public $nama, public $deskripsi, public TypeData $option = TypeData::Entity) {}

    public function GetDeskripsi(){
        return $this->deskripsi;
    }
}