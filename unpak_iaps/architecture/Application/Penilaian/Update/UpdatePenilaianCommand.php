<?php

namespace Architecture\Application\Penilaian\Update;

use Architecture\Application\Abstractions\Messaging\Command;
use Architecture\Shared\IdentityCommand;
use Architecture\Shared\TypeData;

class UpdatePenilaianCommand extends Command
{
    use IdentityCommand;
    public function __construct(public $id, public $matriks, public $nama_berkas, public $url, public TypeData $option = TypeData::Entity) {}

    public function GetMatriks(){
        return $this->matriks;
    }

    public function GetNamaBerkas(){
        return $this->nama_berkas;
    }

    public function GetUrl(){
        return $this->url;
    }
}