<?php

namespace Architecture\Application\DokumenInduk\Update;

use Architecture\Application\Abstractions\Messaging\Command;
use Architecture\Shared\IdentityCommand;
use Architecture\Shared\TypeData;

class UpdateDokumenIndukCommand extends Command
{
    use IdentityCommand;
    public function __construct(public $id, public $nama_berkas, public $url, public $file=null, public $tahun, public TypeData $option = TypeData::Entity) {}

    public function GetNamaBerkas(){
        return $this->nama_berkas;
    }

    public function GetTahun(){
        return $this->tahun;
    }

    public function GetUrl(){
        return $this->url;
    }

    public function GetFile(){
        return $this->file;
    }
}