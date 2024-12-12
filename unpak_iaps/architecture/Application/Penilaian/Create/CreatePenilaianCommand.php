<?php

namespace Architecture\Application\Penilaian\Create;

use Architecture\Application\Abstractions\Messaging\Command;
use Architecture\Shared\TypeData;

class CreatePenilaianCommand extends Command
{
    public function __construct(public $matriks, public $nama_berkas, public $url, public $tahun, public TypeData $option = TypeData::Entity) {}

    public function GetMatriks(){
        return $this->matriks;
    }

    public function GetNamaBerkas(){
        return $this->nama_berkas;
    }

    public function GetTahun(){
        return $this->tahun;
    }

    public function GetUrl(){
        return $this->url;
    }
}