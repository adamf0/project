<?php

namespace Architecture\Application\DokumenInduk\Create;

use Architecture\Application\Abstractions\Messaging\Command;
use Architecture\Shared\TypeData;

class CreateDokumenIndukCommand extends Command
{
    public function __construct(public $nama_berkas, public $url, public $file=null, public $tahun, public TypeData $option = TypeData::Entity) {}

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